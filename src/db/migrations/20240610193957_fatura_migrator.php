<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class FaturaMigrator extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('faturas');
        $table
            ->addColumn('cadastro_id', 'integer', ['null' => false])
            ->addColumn('assinatura_id', 'integer', ['null' => false])
            ->addColumn('descricao', 'string', ['null' => false])
            ->addColumn('vencimento', 'date', ['null' => false])
            ->addColumn('valor', 'float', ['null' => false]);


        $table->addForeignKey("cadastro_id", "cadastros", "id");
        $table->addForeignKey("assinatura_id", "assinaturas", "id");

        $table->create();
    }
}
