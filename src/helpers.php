<?php
function externalLoginUrl($externalUrl, $path) {
    $manager = new \Julfiker\SingleAuth\SingleAuthorizeManager();
    return $externalUrl.route('single.login.redirect',
            [
                'token' => $manager->generateToken(),
                'redirect' =>  $externalUrl."/".$path
            ],
        false
    );
}
