<?php

use Ds\Foundations\Migrate\Column;
use Ds\Foundations\Migrate\Migrations;
use Ds\Foundations\Migrate\Scheme;

return new class implements Migrations
{
    public function up(Scheme $scheme)
    {
        $scheme->createTable(
            'users',
            function (Column $column) {
                $column
                    ->id()
                    ->string('fullname')->notNull()
                    ->string('username')->notNull()
                    ->string('email')->notNull()
                    ->text('password')->notNull()
                    ->string('phone', 18)->notNull()
                    ->date('birth')->notNull()
                    ->string('birth_place')
                    ->char('gender')
                    ->text('bio')
                    ->text('avatar')
                    ->datetime('verified_at')
                    ->createdAt()
                    ->timestamp('updated_at');
            }
        );
    }
    public function down(Scheme $scheme)
    {
        // $scheme->dropIfExist('users');
    }
};
