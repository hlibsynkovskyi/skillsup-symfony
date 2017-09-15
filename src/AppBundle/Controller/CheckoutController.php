<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CheckoutController extends Controller
{

    /**
     * @Route("checkout/success", name="checkout_success")
     *
     * @return Response
     */
    public function successAction()
    {
        return $this->render('checkout/success.html.twig');
    }

    /**
     * @Route("checkout/response", name="checkout_response")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function responseAction(Request $request)
    {
        $content = "POST:\n";
        $content .= var_export($request->request->all(), true);
        $content .= "\n\nGET:\n";
        $content .= var_export($request->query->all(), true);

        file_put_contents($this->getParameter('kernel.project_dir') . '/var/privat.log', $content);

        $payment = $request->request->get('payment');
        $signature = $request->request->get('signature');
        $paymentSignature = sha1(md5($payment.$this->getParameter('privat24_merchant')));

        return new Response('OK');
    }

}
