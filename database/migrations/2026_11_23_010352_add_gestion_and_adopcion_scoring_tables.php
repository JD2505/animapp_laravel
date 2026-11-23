<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Agregar imagen y descripción a mascotas y productos (si no existen)
        Schema::table('mascotas', function (Blueprint $table) {
            if (!Schema::hasColumn('mascotas', 'imagen')) {
                $table->string('imagen')->nullable()->after('edad_aproximada');
            }
            if (!Schema::hasColumn('mascotas', 'descripcion')) {
                $table->text('descripcion')->nullable()->after('imagen');
            }
        });

        Schema::table('productos', function (Blueprint $table) {
            if (!Schema::hasColumn('productos', 'imagen')) {
                $table->string('imagen')->nullable()->after('categoria');
            }
            if (!Schema::hasColumn('productos', 'descripcion')) {
                $table->text('descripcion')->nullable()->after('imagen');
            }
        });

        // 2. Agregar puntaje y diagnóstico de idoneidad a solicitudes_adopcion
        Schema::table('solicitudes_adopcion', function (Blueprint $table) {
            if (!Schema::hasColumn('solicitudes_adopcion', 'puntaje')) {
                $table->integer('puntaje')->default(0)->after('mascota_id');
            }
            if (!Schema::hasColumn('solicitudes_adopcion', 'resultado_evaluacion')) {
                $table->string('resultado_evaluacion')->default('Pendiente')->after('puntaje');
            }
            if (!Schema::hasColumn('solicitudes_adopcion', 'respuestas_detalle')) {
                $table->text('respuestas_detalle')->nullable()->after('resultado_evaluacion');
            }
        });

        // 3. Tabla de Vacunaciones
        if (!Schema::hasTable('vacunaciones')) {
            Schema::create('vacunaciones', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('cliente_id')->nullable();
                $table->string('nombre_mascota');
                $table->string('vacuna_aplicada');
                $table->date('fecha_aplicacion');
                $table->date('proxima_vacuna')->nullable();
                $table->text('observaciones')->nullable();
                $table->unsignedBigInteger('registrado_por')->nullable();
                $table->timestamps();
            });
        }

        // 4. Tabla de Reportes Médicos / Operativos
        if (!Schema::hasTable('reportes')) {
            Schema::create('reportes', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('cliente_id')->nullable();
                $table->string('titulo');
                $table->string('tipo_reporte'); // Consulta, Vacunación, Seguimiento Adopción, Inventario
                $table->text('descripcion');
                $table->unsignedBigInteger('autor_id');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('reportes');
        Schema::dropIfExists('vacunaciones');
    }
};