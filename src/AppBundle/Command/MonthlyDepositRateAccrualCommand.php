<?php
/* cron launch "0 5 1 * *" */
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MonthlyDepositRateAccrualCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:deposit-rate-accrual')
            ->setDescription('Monthly Deposit Rate Calculation');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $depositAccrualOperation = $this->getContainer()->get('app.service.deposit_accrual_operation');
        $deposits = $this->getContainer()->get('app.customer_deposit_repository')
            ->findDepositsByDayCreation($depositAccrualOperation->getOperationDays());

        foreach($deposits as $deposit) {
            //TODO: По хорошему здесь нужно добавлять задания в очередь, а не проводить рассчеты. Но для тестового задания сойдет)
            $depositAccrualOperation->proceed($deposit);
        }
    }
}
