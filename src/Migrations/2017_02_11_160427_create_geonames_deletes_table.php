<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'geonames_deletes', function ( Blueprint $table ) {
            $table->engine = 'MyISAM';
            $table->increments( 'id' );       // Primary key of this table. Possible that we could use geonameid. Can a record be added after it's deleted?
            $table->date( \MichaelDrennen\Geonames\Models\GeonamesDelete::date );           // The date that this record was removed from the geonames database.
            $table->integer( \MichaelDrennen\Geonames\Models\GeonamesDelete::geonameid );   // geonameid         : integer id of record in geonames database
            $table->string( \MichaelDrennen\Geonames\Models\GeonamesDelete::name,
                            200 );    // name              : name of geographical point (utf8) varchar(200)
            $table->string( \MichaelDrennen\Geonames\Models\GeonamesDelete::reason,
                            255 );   // The reason that this record was deleted.
            $table->timestamps();           // Laravel's created_at and updated_at timestamp fields.

            $table->unique( [
                                \MichaelDrennen\Geonames\Models\GeonamesDelete::geonameid,
                                \MichaelDrennen\Geonames\Models\GeonamesDelete::date,
                            ] );
        } );


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'geonames_deletes' );
    }
};
