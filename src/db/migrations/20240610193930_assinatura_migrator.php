<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AssinaturaMigrator extends AbstractMigration
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
        $table = $this->table('assinaturas');
        $table
            ->addColumn('cadastro_id', 'integer', ['null' => false])
            ->addColumn('descricao', 'string')
            ->addColumn("vencimento", 'date', ['null' => false])
            ->addColumn('valor', 'float', ['null' => false]);

        $table->addForeignKey("cadastro_id", "cadastros", "id");

        $table->create();
    }
}
