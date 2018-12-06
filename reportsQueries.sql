/* Убыток или прибыль банка по месяцам. (Сумма комиссий - Сумма начисленных процентов) */
select
  SUM((SELECT SUM(amount) FROM `customer_deposit_operation` cdo WHERE cdo.`customer_deposit_id` = cd.id and cdo.type = 1)) as roschod,
  SUM((SELECT SUM(amount) FROM `customer_deposit_operation` cdo WHERE cdo.`customer_deposit_id` = cd.id and cdo.type = 2)) as profit
from `customer_account` ca
join `customer_deposit` cd ON ca.`id` = cd.`customer_account_id`
group by MONTH(ca.`date_create`)

/* Средняя сумма депозита (Сумма депозитов/Количество депозитов) для возрастных групп:
I группа - От 18 до 25 лет
II группа - От 25 до 50 лет
III группа - От 50 лет
 */

/* Запрос возвращает среднюю суму депозита для первой группы.
Для вывода отчета необходимо выполнить 3 запроса(изменив условия выборки по возросту) */

select AVG(cd.`initial_mount`) as group1
from `customer_deposit` cd
join `customer_account` ca on cd.`customer_account_id` = ca.`id`
join customer c on ca.`customer_id` = c.id
where YEAR(CURDATE()) - YEAR(c.`date_birth`) >= 18 and YEAR(CURDATE()) - YEAR(c.`date_birth`) < 25