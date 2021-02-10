<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209154143 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create Invoice Report View';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql($this->getDropQuery());
        $this->addSql($this->getGenerateQuery());
    }

    public function down(Schema $schema) : void
    {
        $this->addSql($this->getDropQuery());
    }

    private function getDropQuery()
    {
        return "DROP VIEW IF EXISTS `view_invoices_report`;";
    }

    private function getGenerateQuery()
    {
        return "
        CREATE VIEW `view_invoices_report` AS
            SELECT i.invoice_num, i.invoice_date, c.client_id, c.client_name, p.product_id, p.product_description AS product, ili.qty, ili.price, (ili.qty * ili.price) AS total
            FROM Invoices AS i
            INNER JOIN Clients AS c ON c.client_id = i.client_id
            INNER JOIN InvoiceLineItems AS ili ON ili.invoice_num = i.invoice_num
            INNER JOIN Products AS p ON ili.product_id = p.product_id;
        ";
    }
}
