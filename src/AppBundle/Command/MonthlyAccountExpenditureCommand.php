<?php
/* cron launch "0 0 * * *" */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MonthlyAccountExpenditureCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:deposit-account-expenditure')
            ->setDescription('Monthly deposit account expenditure calculation');
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
        $depositExpenditureOperation = $this->getContainer()->get('app.service.deposit_expenditure_operation');
        $deposits = $this->getContainer()->get('app.customer_deposit_repository')->findAll();

        foreach ($deposits as $deposit) {
            //TODO: По хорошему здесь нужно добавлять задания в очередь, а не проводить рассчеты. Но для тестового задания сойдет)
            $depositExpenditureOperation->proceed($deposit);
        }
    }
}
