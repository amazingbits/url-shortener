<?php

namespace Src\Controller;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Src\Error\BadRequestError;
use Src\Error\ExpiredUrlError;
use Src\Error\InternalServerError;
use Src\Error\NotFoundError;
use Src\Model\Entity\Url;

class APIController extends Controller
{
    public function shortenURL(): void
    {
        $data = get_data();
        if (!isset($data["url"])) {
            throw new BadRequestError("the parameter 'url' is not set");
        }
        $short_code = generate_short_code();
        $expiration_date = get_expiration_date((int)getenv("SHORT_URL_EXPIRATION_TIME_IN_DAYS"));
        $url = new Url();
        $url->short_code = $short_code;
        $url->original_url = $data["url"];
        $url->expiration_date = $expiration_date;
        if (!$url->save()) {
            throw new InternalServerError();
        }

        $this->json(["url" => getenv("BASE_URL") . "/" . $short_code]);
    }

    public function redirectURL($data): void
    {
        $shortCode = $data["shortCode"];

        $url = Url::where("short_code", $shortCode)->first();

        if (empty($url)) {
            throw new NotFoundError();
        }

        $now = new \DateTime();
        $expiration_date = new \DateTime($url->expiration_date);
        if ($expiration_date <= $now) {
            throw new ExpiredUrlError();
        }

        $this->json(["url" => $url->original_url]);
    }

    public function makeQRCode(): void
    {
        $data = get_data();
        if (!isset($data["url"])) {
            throw new BadRequestError("the parameter 'url' is not set");
        }
        $url = $data["url"];
        $size = isset($data["size"]) ? (int)$data["size"] : 300;
        $logo = isset($data["logo"]) ? (string)$data["logo"] : null;
        $label = isset($data["label"]) ? (string)$data["label"] : null;

        $writer = new PngWriter();
        $qrCode = new QrCode(
            data: $url,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Low,
            size: $size,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255)
        );

        $customLogo = null;
        $tempFile = null;
        if ($logo) {
            $imageContent = file_get_contents($logo);
            $tempFile = tempnam(sys_get_temp_dir(), 'logo_') . '.png';
            file_put_contents($tempFile, $imageContent);

            $customLogo = new Logo(
                path: $tempFile,
                resizeToWidth: 50,
                punchoutBackground: true
            );
        }

        $customLabel = null;
        if ($label) {
            $customLabel = new Label(
                text: $label,
                textColor: new Color(65, 65, 65)
            );
        }

        $result = $writer->write($qrCode, $customLogo, $customLabel);

        $qrcodeImage = $result->getDataUri();

        if ($customLogo && file_exists($tempFile)) {
            unlink($tempFile);
        }

        $qrcodeObject = new \Src\Model\Entity\QrCode();
        $qrcodeObject->qrcode = $qrcodeImage;
        $qrcodeObject->original_url = $url;
        if (!$qrcodeObject->save()) {
            throw new InternalServerError();
        }

        $this->json(["qrcode" => $result->getDataUri()]);
    }
}