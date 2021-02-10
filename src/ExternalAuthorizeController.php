<?php
namespace Julfiker\SingleAuth;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ExternalAuthorizeController extends Controller
{

    /**
     * Controller to direct external url
     *
     * @param Request $request
     * @param SingleAuthorizeManager $authorizeManager
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function redirect(Request $request, SingleAuthorizeManager $authorizeManager) {
        $redirectTo = $request->get('redirect');
        $id = $authorizeManager->decrypt($request->get('token'));

        if (!$id)
            abort(403);

         $user = $authorizeManager->authenticate($id);

         if ($user && $user->user_id == $id)
          return Redirect::away($redirectTo);

         abort(403);
    }
}
