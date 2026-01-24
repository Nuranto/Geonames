<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {

    const TABLE = 'geonames_admin_1_codes';

    /**
     * Run the migrations.
     * Source of data: http://download.geonames.org/export/dump/admin1CodesASCII.txt
     * Sample data:
     * US.CO    Colorado    Colorado    5417618
     */
    public function up(): void {
        // In the command that I run to fill this table, I split the concatenated values in column 1 into
        // country_code and admin1_code
        Schema::create( self::TABLE, function ( Blueprint $table ) {
            $table->engine = 'MyISAM';
            $table->integer( 'geonameid', FALSE, TRUE )->primary();         // 5417618
            $table->char( 'country_code', 2 );      // US
            $table->string( 'admin1_code', 20 );    // CO
            $table->string( 'name', 255 );          // Colorado
            $table->string( 'asciiname', 255 );     // Colorado
            $table->timestamps();

            $table->index( 'country_code' );
            $table->index( 'admin1_code' );


        } );

        /**
         * Create a prefixed index for MySQL databases.
         * There is a problem with MySQL unable to create indexes over a certain length.
         * @see https://github.com/michaeldrennen/Geonames/issues/30
         */
        $connection = config( 'database.default' );
        $driver     = config( "database.connections.{$connection}.driver" );

        if ( config( 'debug.running_in_continuous_integration' ) ):
            echo "\nRUNNING THIS TEST IN CI. Index on asciiname(250) won't be created on the admin_1_codes table.";
            flush();
        elseif ( 'mysql' == $driver || 'mariadb' == $driver ):
            echo "\nRunning the mysql database driver. I'll create an index on asciiname(250) on the admin_1_codes";
            flush();
            \Illuminate\Support\Facades\DB::statement(
                'CREATE INDEX geonames_admin_1_codes_asciiname_index ON ' . self::TABLE . ' (asciiname(250))'
            );
        else:
            echo "\n\nNot running the MySQL database driver. You may want to manually create an index on asciiname(250) in the admin_1_codes table.\n\n";
            flush();
        endif;

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( self::TABLE );
    }
};
