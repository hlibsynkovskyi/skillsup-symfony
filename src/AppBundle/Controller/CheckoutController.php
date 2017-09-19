<?php
/**
 * Created by PhpStorm.
 * User: SkillUP student
 * Date: 12.09.2017
 * Time: 17:14
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Order;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class CheckoutController extends Controller
{
    /**
     * @Route("checkout/success/{id}", name="checkout_success")
     *
     * @param Order $order
     *
     * @return Response
     */
    public function successAction(Order $order)
    {
        return $this->render('checkout/success.html.twig', ['order' => $order]);
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
        // Сохранение последнего запроса от Привата в лог (5 строк)
        $content = "POST:\n";
        $content .= var_export($request->request->all(), true);
        $content .= "\n\nGET:\n";
        $content .= var_export($request->query->all(), true);
        file_put_contents($this->getParameter('kernel.project_dir') . '/var/privat.log', $content);

        // Данные платежа в переменную
        $payment = $request->request->get('payment');
        // Подпись в переменную
        $signature = $request->request->get('signature');
        //Вычисляем подпись для сравнения
        $paymentSignature = sha1(md5($payment.$this->getParameter('privat24_merchant_password')));

        if ( $signature != $paymentSignature ) {
            // Если подписи не совпадают - то это не Приват, а хакер. Выходим с HTTP 403 Access Denied
            throw new AccessDeniedHttpException();
        }

        // преобразование мтроки с параметрами заапроса в массив $result
        parse_str($payment, $result);
        //Номер заказа  переменную
        $orderId = $result['order'];

        //Получаем сревис для работі с БД
        $doctrine = $this->get('doctrine');
        $em = $doctrine->getManager();

        // Загружем заказ из БД
        /** @var Order $order */
        $order = $em->find(Order::class, $orderId);

        if (!$order) {
            throw new NotFoundHttpException();
        }

        if($result['state'] == 'test' || $result['state'] == 'ok') {
            //оплата прошла, ставим успешный статус и дату
            $order->setPaymentStatus(Order::PAYMENT_STATUS_SUCCESS);
            $order->setPaymentDate(new \DateTime());
        } elseif ($result['state'] == 'fail') {
            //оплата не прошлаб ставим статус с ошибкой
            $order->setPaymentStatus(Order::PAYMENT_STATUS_FAIL);
        }

        $em->flush();

        return new Response('OK');
    }

}