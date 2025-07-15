<?php
// database/migrations/xxxx_xx_xx_add_shipper_to_orders_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShipperToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            
            $table->foreignId('shipper_id')
                ->nullable()
                ->after('user_id')
                ->constrained('shippers')
                ->nullOnDelete();
            $table->timestamp('assigned_at')->nullable()->after('shipper_id');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipper_id', 'assigned_at']);
        });
    }
}
