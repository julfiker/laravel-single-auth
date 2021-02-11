<?php
function externalLoginUrl($externalUrl, $path) {
    $manager = new \Julfiker\SingleAuth\SingleAuthorizeManager();

    try {
        $link = $externalUrl . route('single.login.redirect',
                [
                    'token' => $manager->generateToken(),
                    'redirect' =>  $path
                ],
                false
            );
    }
    catch (\Exception $e) {
       throw new Exception('Single auth package not configured yet!');
    }

    return $link;
}
