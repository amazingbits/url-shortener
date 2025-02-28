<?php

namespace Src\Controller;

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
}