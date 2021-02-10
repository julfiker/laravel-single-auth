<?php
namespace Julfiker\SingleAuth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class SingleAuthorizeManager
{
    private $user;
    protected $pubkey = '';
    protected $privkey =  '';

    private $auth;

    public function __construct()
    {
        $this->auth = auth();
        $this->privkey = file_get_contents(__DIR__.'/ssl/private.pem');
        $this->pubkey = file_get_contents(__DIR__.'/ssl/public.pem');
    }

    /**
     * Generate token
     *
     * @return string
     * @throws \Exception
     */
    public function generateToken() {

        if (!($this->privkey && $this->pubkey))
            throw new \Exception('Public key or Private key missing!!');

       if (!$this->auth->user())
           throw new \Exception('Found unauthorized!!');

       return $this->encrypt($this->auth->id());
    }

    /**
     * Force login by id
     *
     * @param $id
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function authenticate($id) {
        if ($id) {
            Auth::loginUsingId($id);
            return Auth::user();
        }
    }

    /**
     * Encrypting based on ssl encrypted
     *
     * @param $data
     * @return string
     * @throws \Exception
     */
    public function encrypt($data)
    {
        try {
            if (openssl_public_encrypt($data, $encrypted, $this->pubkey))
                $data = base64_encode($encrypted);
            else
                throw new \Exception('Unable to encrypt data. Perhaps it is bigger than the key size?');
        } catch (\Exception $e) {
            throw $e;
        }
        return $data;
    }

    /**
     * Decrypted data based on hash value
     *
     * @param $data
     * @return string
     * @throws \Exception
     */
    public function decrypt($data)
    {
        try {
            if (openssl_private_decrypt(base64_decode($data), $decrypted, openssl_pkey_get_private($this->privkey, "julfiker")))
                $data = $decrypted;
            else
                $data = '';


        } catch (\Exception $e) {
             throw  $e;
        }
        return $data;
    }
}
