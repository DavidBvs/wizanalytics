<?php
// src/Controller/AppAdminController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class AdminController
{
    public function displayPhpInfo()
    {
        return new Response(
			'<html><body>' . phpinfo() . '</body></html>'
        );
    }

}