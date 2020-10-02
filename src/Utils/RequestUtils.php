<?php
namespace Jeansf\Common\Utils;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestUtils
{
    static function getPeriod(ParameterBag $bag) {
        $startDate = null;
        $endDate = null;
        if($bag->has('period') && $bag->get('period')) {
            $period = strtoupper($bag->get('period'));
            if(!in_array($period,['Y','M','W','D']))
                throw new BadRequestHttpException('Período inválido!');
            $endDate = new \DateTime();
            $startDate = (clone $endDate)->sub(new \DateInterval('P1'.$period))->setTime(0,0,0,0);
        } elseif ($bag->has('start') && $bag->has('end') && $bag->get('start') && $bag->get('end')) {
            try {
                $startDate = new \DateTime($bag->get('start'));
                $endDate = new \DateTime($bag->get('end'));
            } catch (\Exception $e) {
                throw new BadRequestHttpException('Datas informadas inválida!');
            }
            $maxDate = new \DateTime();
            if($endDate > $maxDate)
                throw new BadRequestHttpException('O período não pode passar da data de hoje!');
            $minDate = (clone $endDate)->sub(new \DateInterval('P1Y'))->setTime(0,0,0,0);
            if($startDate < $minDate)
                throw new BadRequestHttpException('Período não pode ser maior que um ano!');
            if($startDate > $endDate)
                throw new BadRequestHttpException('Data inicial maior que a data final!');
        } else {
            $endDate = new \DateTime();
            $startDate = (clone $endDate)->sub(new \DateInterval('P1Y'))->setTime(0,0,0,0);
        }

        return new \DatePeriod($startDate, new \DateInterval('P1Y'), $endDate);
    }
}
