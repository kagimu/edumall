    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable(); // nullable for guest checkout
                $table->string('customer_name');
                $table->string('customer_email');
                $table->string('customer_phone');
                $table->json('delivery_info');
                $table->decimal('subtotal', 10, 2);
                $table->decimal('delivery_fee', 10, 2);
                $table->decimal('total', 10, 2);
                $table->string('payment_method'); // e.g. 'cod', 'flutterwave'
                $table->string('payment_status')->default('pending'); // 'paid', 'pending'
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('orders');
        }
    };
