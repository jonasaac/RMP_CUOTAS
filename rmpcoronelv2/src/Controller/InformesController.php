<?php
namespace App\Controller;

use Cake\I18n\Time;

class InformesController extends AppController
{
  public function isAuthorized($user = null)
  {
    return true;
  }

  public function gerencia()
  {
    $year = date('Y');
    $fechaConsulta = time();
    $recursosIds = [1, 3]; // Sardinas y Jureles
    $sardinaId = 1;
    $jurelId = 3;

    if ($this->request->is(['post'])) {
      $fechaConsulta = $this->request->data('fecha_consulta_unix');
    }

    // Jurel Industrial
    $query = $this->loadModel('Naves')->find();
    $query->select([
      'id' => 'Naves.id',
      'nombre' => 'Naves.nombre',
      'total_diario' => $query->func()->sum('CASE WHEN DATEPART(dy, DescargaEncabezados.inicio_desembarque) = '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END'),
      'total_semanal' => $query->func()->sum('CASE WHEN DATEPART(wk, DescargaEncabezados.inicio_desembarque) = '.date('W', $fechaConsulta).' AND DATEPART(dy, DescargaEncabezados.inicio_desembarque) <= '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END'),
      'total_mensual' => $query->func()->sum('CASE WHEN MONTH(DescargaEncabezados.inicio_desembarque) = '.date('m', $fechaConsulta).' AND DATEPART(dy, DescargaEncabezados.inicio_desembarque) <= '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END'),
      'total_anual' => $query->func()->sum('CASE WHEN DATEPART(dy, DescargaEncabezados.inicio_desembarque) <= '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END')
    ])
    ->contain(['Regimenes'])
    ->matching('Recursos', function ($q) use ($jurelId) {
      return $q->where(['Recursos.id' => $jurelId]);
    })
    ->matching('Mareas.Recaladas.DescargaEncabezados.DescargaDetalles.Unidades', function ($q) use ($year, $fechaConsulta, $jurelId) {
      return $q->where([
        'YEAR(Mareas.fecha_zarpe)' => $year,
        'Mareas.recurso_id' => $jurelId
      ]);
    })
    ->where(['Regimenes.id' => 1]) // Solo industriales
    ->order(['Naves.nombre' => 'ASC'])
    ->group(['Naves.id', 'Naves.nombre']);

    $navesIndustrialesJurel = $query;
    $totalesIndustrialJurel = [];
    foreach ($navesIndustrialesJurel as $nave) {
        $totalesIndustrialJurel[ $nave->nombre ][ 'diario' ] = round($nave->total_diario);
        $totalesIndustrialJurel[ $nave->nombre ][ 'semanal' ] = round($nave->total_semanal);
        $totalesIndustrialJurel[ $nave->nombre ][ 'mensual' ] = round($nave->total_mensual);
        $totalesIndustrialJurel[ $nave->nombre ][ 'anual' ] = round($nave->total_anual);
    }

    // Sardina Industrial
    $query = $this->loadModel('Naves')->find('all');
    $query->select([
      'id' => 'Naves.id',
      'nombre' => 'Naves.nombre',
      'total_diario' => $query->func()->sum('CASE WHEN DATEPART(dy, DescargaEncabezados.inicio_desembarque) = '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END'),
      'total_semanal' => $query->func()->sum('CASE WHEN DATEPART(wk, DescargaEncabezados.inicio_desembarque) = '.date('W', $fechaConsulta).' AND DATEPART(dy, DescargaEncabezados.inicio_desembarque) <= '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END'),
      'total_mensual' => $query->func()->sum('CASE WHEN MONTH(DescargaEncabezados.inicio_desembarque) = '.date('m', $fechaConsulta).' AND DATEPART(dy, DescargaEncabezados.inicio_desembarque) <= '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END'),
      'total_anual' => $query->func()->sum('CASE WHEN DATEPART(dy, DescargaEncabezados.inicio_desembarque) <= '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END')
    ])
    ->contain(['Regimenes'])
    ->matching('Recursos', function ($q) use ($sardinaId) {
      return $q->where(['Recursos.id' => $sardinaId]);
    })
    ->matching('Mareas.Recaladas.DescargaEncabezados.DescargaDetalles.Unidades', function ($q) use ($year, $sardinaId) {
      return $q->where([
        'YEAR(Mareas.fecha_zarpe)' => $year,
        'Mareas.recurso_id' => $sardinaId
      ]);
    })
    ->where(['Regimenes.id' => 1]) // Solo industriales
    ->order(['Naves.nombre' => 'ASC'])
    ->group(['Naves.id', 'Naves.nombre']);

    $navesIndustrialesSardina = $query;
    $totalesIndustrialSardina = [];
    foreach ($navesIndustrialesSardina as $nave) {
        $totalesIndustrialSardina[ $nave->nombre ][ 'diario' ] = round($nave->total_diario);
        $totalesIndustrialSardina[ $nave->nombre ][ 'semanal' ] = round($nave->total_semanal);
        $totalesIndustrialSardina[ $nave->nombre ][ 'mensual' ] = round($nave->total_mensual);
        $totalesIndustrialSardina[ $nave->nombre ][ 'anual' ] = round($nave->total_anual);
    }

    // Flota Artesanal
    $query = $this->loadModel('Naves')->find('all');
    $query->select([
      'id' => 'ZonaOperaciones.id',
      'nombre' => 'ZonaOperaciones.nombre',
      'total_diario' => $query->func()->sum('CASE WHEN DATEPART(dy, DescargaEncabezados.inicio_desembarque) = '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END'),
      'total_semanal' => $query->func()->sum('CASE WHEN DATEPART(wk, DescargaEncabezados.inicio_desembarque) = '.date('W', $fechaConsulta).' AND DATEPART(dy, DescargaEncabezados.inicio_desembarque) <= '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END'),
      'total_mensual' => $query->func()->sum('CASE WHEN MONTH(DescargaEncabezados.inicio_desembarque) = '.date('m', $fechaConsulta).' AND DATEPART(dy, DescargaEncabezados.inicio_desembarque) <= '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END'),
      'total_anual' => $query->func()->sum('CASE WHEN DATEPART(dy, DescargaEncabezados.inicio_desembarque) <= '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END')
    ])
    ->contain(['Regimenes', 'ZonaOperaciones'])
    ->matching('Mareas.Recaladas.DescargaEncabezados.DescargaDetalles.Unidades', function ($q) use ($year, $sardinaId) {
      return $q->where([
        'YEAR(Mareas.fecha_zarpe)' => $year,
        'Mareas.recurso_id' => $sardinaId
      ]);
    })
    ->matching('Recursos', function ($q) use ($sardinaId) {
      return $q->where(['Recursos.id' => $sardinaId]);
    })
    ->where(['Regimenes.id' => 2]) // Solo artesanales
    ->group(['ZonaOperaciones.id', 'ZonaOperaciones.nombre']);

    $navesArtesanalesSardina = $query;
    $totalesArtesanalSardina = [];
    foreach ($navesArtesanalesSardina as $nave) {
        $totalesArtesanalSardina[ $nave->nombre ][ 'diario' ] = round($nave->total_diario);
        $totalesArtesanalSardina[ $nave->nombre ][ 'semanal' ] = round($nave->total_semanal);
        $totalesArtesanalSardina[ $nave->nombre ][ 'mensual' ] = round($nave->total_mensual);
        $totalesArtesanalSardina[ $nave->nombre ][ 'anual' ] = round($nave->total_anual);
    }

    // Plantas de Destino
    $query = $this->loadModel('Plantas')->find('all');
    $query->select([
      'id' => 'Plantas.id',
      'nombre' => 'Recintos.nombre',
      'total_diario' => $query->func()->sum('CASE WHEN DATEPART(dy, GuiaEncabezados.fecha_salida) = '.(date('z', $fechaConsulta)+1).' THEN GuiaDetallesUnidades.cantidad ELSE 0 END'),
      'total_semanal' => $query->func()->sum('CASE WHEN DATEPART(wk, GuiaEncabezados.fecha_salida) = '.date('W', $fechaConsulta).' AND DATEPART(dy, GuiaEncabezados.fecha_salida) <= '.(date('z', $fechaConsulta)+1).' THEN GuiaDetallesUnidades.cantidad ELSE 0 END'),
      'total_mensual' => $query->func()->sum('CASE WHEN MONTH(GuiaEncabezados.fecha_salida) = '.date('m', $fechaConsulta).' AND DATEPART(dy, GuiaEncabezados.fecha_salida) <= '.(date('z', $fechaConsulta)+1).' THEN GuiaDetallesUnidades.cantidad ELSE 0 END'),
      'total_anual' => $query->func()->sum('CASE WHEN DATEPART(dy, GuiaEncabezados.fecha_salida) <= '.(date('z', $fechaConsulta)+1).' THEN GuiaDetallesUnidades.cantidad ELSE 0 END')
    ])
    ->contain(['Recintos'])
    ->matching('GuiaEncabezados.GuiaDetalles.Unidades', function ($q) use ($year, $sardinaId) {
      return $q->where(['YEAR(GuiaEncabezados.fecha_salida)' => $year]);
    })
    ->order(['Recintos.nombre' => 'ASC'])
    ->group(['Plantas.id', 'Recintos.nombre']);

    $plantas = $query;
    $totalesPlantas = [];
    foreach ($plantas as $planta) {
        $totalesPlantas[ $planta->nombre ][ 'diario' ] = round($planta->total_diario);
        $totalesPlantas[ $planta->nombre ][ 'semanal' ] = round($planta->total_semanal);
        $totalesPlantas[ $planta->nombre ][ 'mensual' ] = round($planta->total_mensual);
        $totalesPlantas[ $planta->nombre ][ 'anual' ] = round($planta->total_anual);
    }

    $this->set(compact('totalesIndustrialJurel', 'totalesIndustrialSardina', 'totalesArtesanalSardina', 'totalesPlantas', 'fechaConsulta'));
  }

  public function gerenciaExcel($fecha = null)
  {
    require_once(ROOT . DS . 'vendor' . DS  . 'phpoffice' . DS . 'phpexcel' . DS . 'Classes' . DS . 'PHPExcel.php');
    $objPHPExcel = new \PHPExcel();

    $year = date('Y');
    $fechaConsulta = !empty($fecha)?$fecha:time();
    $recursosIds = [1, 3]; // Sardinas y Jureles
    $sardinaId = 1;
    $jurelId = 3;

    if ($this->request->is(['post'])) {
      $fechaConsulta = $this->request->data('fecha_consulta_unix');
    }

    // 38040
    // 403,732 TON

    //$fecha_text = Time::createFromTimestamp($fechaConsulta);
    $fecha_text = date('Y-m-d', $fechaConsulta);
    $fecha_full = Time::createFromTimestamp($fechaConsulta)->i18nFormat("cccc, d 'de' LLLL 'de' YYYY", null, 'es-ES');;
    $fecha_numeros = date('Y-m-d', $fechaConsulta);

    // Industrial Jurel
    $query = $this->loadModel('Naves')->find();
    $query->select([
      'id' => 'Naves.id',
      'nombre' => 'Naves.nombre',
      'total_diario' => $query->func()->sum('CASE WHEN DATEPART(dy, DescargaEncabezados.inicio_desembarque) = '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END'),
      'total_semanal' => $query->func()->sum('CASE WHEN DATEPART(wk, DescargaEncabezados.inicio_desembarque) = '.date('W', $fechaConsulta).' AND DATEPART(dy, DescargaEncabezados.inicio_desembarque) <= '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END'),
      'total_mensual' => $query->func()->sum('CASE WHEN MONTH(DescargaEncabezados.inicio_desembarque) = '.date('m', $fechaConsulta).' AND DATEPART(dy, DescargaEncabezados.inicio_desembarque) <= '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END'),
      'total_anual' => $query->func()->sum('CASE WHEN DATEPART(dy, DescargaEncabezados.inicio_desembarque) <= '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END')
    ])
    ->contain(['Regimenes'])
    ->matching('Recursos', function ($q) use ($jurelId) {
      return $q->where(['Recursos.id' => $jurelId]);
    })
    ->matching('Mareas.Recaladas.DescargaEncabezados.DescargaDetalles.Unidades', function ($q) use ($year, $fechaConsulta, $jurelId) {
      return $q->where([
        'YEAR(Mareas.fecha_zarpe)' => $year,
        'Mareas.recurso_id' => $jurelId
      ]);
    })
    ->where(['Regimenes.id' => 1]) // Solo industriales
    ->order(['Naves.nombre' => 'ASC'])
    ->group(['Naves.id', 'Naves.nombre']);

    $navesIndustrialesJurel = $query;
    $totalesIndustrialJurel = [];
    foreach ($navesIndustrialesJurel as $nave) {
        $totalesIndustrialJurel[ $nave->nombre ][ 'diario' ] = round($nave->total_diario);
        $totalesIndustrialJurel[ $nave->nombre ][ 'semanal' ] = round($nave->total_semanal);
        $totalesIndustrialJurel[ $nave->nombre ][ 'mensual' ] = round($nave->total_mensual);
        $totalesIndustrialJurel[ $nave->nombre ][ 'anual' ] = round($nave->total_anual);
    }

    // Sardina Industrial
    $query = $this->loadModel('Naves')->find('all');
    $query->select([
      'id' => 'Naves.id',
      'nombre' => 'Naves.nombre',
      'total_diario' => $query->func()->sum('CASE WHEN DATEPART(dy, DescargaEncabezados.inicio_desembarque) = '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END'),
      'total_semanal' => $query->func()->sum('CASE WHEN DATEPART(wk, DescargaEncabezados.inicio_desembarque) = '.date('W', $fechaConsulta).' AND DATEPART(dy, DescargaEncabezados.inicio_desembarque) <= '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END'),
      'total_mensual' => $query->func()->sum('CASE WHEN MONTH(DescargaEncabezados.inicio_desembarque) = '.date('m', $fechaConsulta).' AND DATEPART(dy, DescargaEncabezados.inicio_desembarque) <= '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END'),
      'total_anual' => $query->func()->sum('CASE WHEN DATEPART(dy, DescargaEncabezados.inicio_desembarque) <= '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END')
    ])
    ->contain(['Regimenes'])
    ->matching('Recursos', function ($q) use ($sardinaId) {
      return $q->where(['Recursos.id' => $sardinaId]);
    })
    ->matching('Mareas.Recaladas.DescargaEncabezados.DescargaDetalles.Unidades', function ($q) use ($year, $sardinaId) {
      return $q->where([
        'YEAR(Mareas.fecha_zarpe)' => $year,
        'Mareas.recurso_id' => $sardinaId
      ]);
    })
    ->where(['Regimenes.id' => 1]) // Solo industriales
    ->order(['Naves.nombre' => 'ASC'])
    ->group(['Naves.id', 'Naves.nombre']);

    $navesIndustrialesSardina = $query;
    $totalesIndustrialSardina = [];
    foreach ($navesIndustrialesSardina as $nave) {
        $totalesIndustrialSardina[ $nave->nombre ][ 'diario' ] = round($nave->total_diario);
        $totalesIndustrialSardina[ $nave->nombre ][ 'semanal' ] = round($nave->total_semanal);
        $totalesIndustrialSardina[ $nave->nombre ][ 'mensual' ] = round($nave->total_mensual);
        $totalesIndustrialSardina[ $nave->nombre ][ 'anual' ] = round($nave->total_anual);
    }

    // Flota Artesanal
    $query = $this->loadModel('Naves')->find('all');
    $query->select([
      'id' => 'ZonaOperaciones.id',
      'nombre' => 'ZonaOperaciones.nombre',
      'total_diario' => $query->func()->sum('CASE WHEN DATEPART(dy, DescargaEncabezados.inicio_desembarque) = '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END'),
      'total_semanal' => $query->func()->sum('CASE WHEN DATEPART(wk, DescargaEncabezados.inicio_desembarque) = '.date('W', $fechaConsulta).' AND DATEPART(dy, DescargaEncabezados.inicio_desembarque) <= '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END'),
      'total_mensual' => $query->func()->sum('CASE WHEN MONTH(DescargaEncabezados.inicio_desembarque) = '.date('m', $fechaConsulta).' AND DATEPART(dy, DescargaEncabezados.inicio_desembarque) <= '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END'),
      'total_anual' => $query->func()->sum('CASE WHEN DATEPART(dy, DescargaEncabezados.inicio_desembarque) <= '.(date('z', $fechaConsulta)+1).' THEN DescargaDetallesUnidades.cantidad ELSE 0 END')
    ])
    ->contain(['Regimenes', 'ZonaOperaciones'])
    ->matching('Mareas.Recaladas.DescargaEncabezados.DescargaDetalles.Unidades', function ($q) use ($year, $sardinaId) {
      return $q->where([
        'YEAR(Mareas.fecha_zarpe)' => $year,
        'Mareas.recurso_id' => $sardinaId
      ]);
    })
    ->matching('Recursos', function ($q) use ($sardinaId) {
      return $q->where(['Recursos.id' => $sardinaId]);
    })
    ->where(['Regimenes.id' => 2]) // Solo artesanales
    ->group(['ZonaOperaciones.id', 'ZonaOperaciones.nombre']);

    $navesArtesanalesSardina = $query;
    $totalesArtesanalSardina = [];
    foreach ($navesArtesanalesSardina as $nave) {
        $totalesArtesanalSardina[ $nave->nombre ][ 'diario' ] = round($nave->total_diario);
        $totalesArtesanalSardina[ $nave->nombre ][ 'semanal' ] = round($nave->total_semanal);
        $totalesArtesanalSardina[ $nave->nombre ][ 'mensual' ] = round($nave->total_mensual);
        $totalesArtesanalSardina[ $nave->nombre ][ 'anual' ] = round($nave->total_anual);
    }

    // Plantas de Destino
    $query = $this->loadModel('Plantas')->find('all');
    $query->select([
      'id' => 'Plantas.id',
      'nombre' => 'Recintos.nombre',
      'total_diario' => $query->func()->sum('CASE WHEN DATEPART(dy, GuiaEncabezados.fecha_salida) = '.(date('z', $fechaConsulta)+1).' THEN GuiaDetallesUnidades.cantidad ELSE 0 END'),
      'total_semanal' => $query->func()->sum('CASE WHEN DATEPART(wk, GuiaEncabezados.fecha_salida) = '.date('W', $fechaConsulta).' AND DATEPART(dy, GuiaEncabezados.fecha_salida) <= '.(date('z', $fechaConsulta)+1).' THEN GuiaDetallesUnidades.cantidad ELSE 0 END'),
      'total_mensual' => $query->func()->sum('CASE WHEN MONTH(GuiaEncabezados.fecha_salida) = '.date('m', $fechaConsulta).' AND DATEPART(dy, GuiaEncabezados.fecha_salida) <= '.(date('z', $fechaConsulta)+1).' THEN GuiaDetallesUnidades.cantidad ELSE 0 END'),
      'total_anual' => $query->func()->sum('CASE WHEN DATEPART(dy, GuiaEncabezados.fecha_salida) <= '.(date('z', $fechaConsulta)+1).' THEN GuiaDetallesUnidades.cantidad ELSE 0 END')
    ])
    ->contain(['Recintos'])
    ->matching('GuiaEncabezados.GuiaDetalles.Unidades', function ($q) use ($year, $sardinaId) {
      return $q->where(['YEAR(GuiaEncabezados.fecha_salida)' => $year]);
    })
    ->order(['Recintos.nombre' => 'ASC'])
    ->group(['Plantas.id', 'Recintos.nombre']);

    $plantas = $query;
    $totalesPlantas = [];
    foreach ($plantas as $planta) {
        $totalesPlantas[ $planta->nombre ][ 'diario' ] = round($planta->total_diario);
        $totalesPlantas[ $planta->nombre ][ 'semanal' ] = round($planta->total_semanal);
        $totalesPlantas[ $planta->nombre ][ 'mensual' ] = round($planta->total_mensual);
        $totalesPlantas[ $planta->nombre ][ 'anual' ] = round($planta->total_anual);
    }

    $this->set(compact(
      'objPHPExcel',
      'fecha_text',
      'fecha_full',
      'fecha_numeros',
      'totalesIndustrialJurel',
      'totalesIndustrialSardina',
      'totalesArtesanalSardina',
      'totalesPlantas'
    ));
  }
}
?>
