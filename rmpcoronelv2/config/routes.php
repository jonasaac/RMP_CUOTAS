<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\Router;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass('Route');

Router::scope('/api', function ($routes) {
    $routes->extensions(['json']);

    $routes->connect('/cuotas', ['controller' => 'Cuotas', 'action' => 'listar']);
    // mareas
    $routes->connect('/mareas', ['controller' => 'Mareas', 'action' => 'listar']);
    $routes->connect('/mareas/:year', ['controller' => 'Mareas', 'action' => 'listar'],
    [
        'pass' => ['year'],
        'year' => '[0-9]+'
    ]);
    $routes->connect('/mareas/:year/:estado', ['controller' => 'Mareas', 'action' => 'listar'],
    [
        'pass' => ['year', 'estado'],
        'year' => '[0-9]+'
    ]);
    //recaladas
    $routes->connect('/recaladas', ['controller' => 'Recaladas', 'action' => 'listar']);
    $routes->connect('/recaladas/:marea', ['controller' => 'Recaladas', 'action' => 'listar'], ['pass' => ['marea'], 'marea' => '[0-9]+']);
    $routes->connect('/recaladas/:marea/:estado', ['controller' => 'Recaladas', 'action' => 'listar'], ['pass' => ['marea', 'estado'], 'marea' => '[0-9]+']);
    //descargas
    $routes->connect('/descargas', ['controller' => 'DescargaEncabezados', 'action' => 'listar']);
    $routes->connect('/descargas/:recalada', ['controller' => 'DescargaEncabezados', 'action' => 'listar'],
    [
        'pass' => ['recalada'],
        'recalada' => '[0-9]+'
    ]);
    $routes->connect('/descargas/:recalada/:estado', ['controller' => 'DescargaEncabezados', 'action' => 'listar'],
    [
        'pass' => ['recalada', 'estado'],
        'recalada' => '[0-9]+'
    ]);
    $routes->connect('/descargas_disponibles/:recursoId', ['controller' => 'DescargaEncabezados', 'action' => 'listarDisponibles'],
    [
      'pass' => ['recursoId'],
      'recursoId' => '[0-9]+'
    ]);
    $routes->connect('/descargas_disponibles_folios/:year',
                     ['controller' => 'DescargaEncabezados', 'action' => 'listarDisponiblesFolios'],
                     [
                       'pass' => ['year'],
                       'year' => '[0-9]*'
                     ]);
    // guias
    $routes->connect('/guias', ['controller' => 'GuiaEncabezados', 'action' => 'listar']);
    $routes->connect('/guias/:year', ['controller' => 'GuiaEncabezados', 'action' => 'listar'],
    [
        'pass' => ['year'],
        'year' => '[0-9]+'
    ]);
    $routes->connect('/guias/:year/:estado', ['controller' => 'GuiaEncabezados', 'action' => 'listar'],
    [
        'pass' => ['year', 'estado'],
        'year' => '[0-9]+'
    ]);
    // folios
    $routes->connect('/folios', ['controller' => 'FolioEncabezados', 'action' => 'listar']);
    $routes->connect('/folios/:year', ['controller' => 'FolioEncabezados', 'action' => 'listar'],
    [
        'pass' => ['year'],
        'year' => '[0-9]+'
    ]);
    $routes->connect('/folios/:year/:estado', ['controller' => 'FolioEncabezados', 'action' => 'listar'],
    [
        'pass' => ['year', 'estado'],
        'year' => '[0-9]+'
    ]);
    //lotes
    $routes->connect('/lotes', ['controller' => 'LoteEncabezados', 'action' => 'listar']);
    $routes->connect('/lotes/:folio', ['controller' => 'LoteEncabezados', 'action' => 'listar'],
    [
        'pass' => ['folio'],
        'folio' => '[0-9]+'
    ]);
    $routes->connect('/lotes/:folio/:estado', ['controller' => 'LoteEncabezados', 'action' => 'listar'],
    [
        'pass' => ['folio', 'estado'],
        'folio' => '[0-9]+'
    ]);
    //calidad
    $routes->connect('/controles_calidad', ['controller' => 'ControlesCalidad', 'action' => 'listar']);
    $routes->connect('/controles_calidad/:year', ['controller' => 'ControlesCalidad', 'action' => 'listar'],
    [
        'pass' => ['year'],
        'year' => '[0-9]+'
    ]);
    $routes->connect('/controles_calidad/:year/:estado', ['controller' => 'ControlesCalidad', 'action' => 'listar'],
    [
        'pass' => ['year', 'estado'],
        'year' => '[0-9]+'
    ]);
    //naves
    $routes->connect('/naves', ['controller' => 'Naves', 'action' => 'listar']);
    $routes->connect('/naves/:estado', ['controller' => 'Naves', 'action' => 'listar'], [
        'pass' => ['estado']
    ]);
    //puertos
    $routes->connect('/puertos', ['controller' => 'Puertos', 'action' => 'listar']);
    $routes->connect('/puertos/:estado', ['controller' => 'Puertos', 'action' => 'listar'], [
        'pass' => ['estado']
    ]);
    //Plantas
    $routes->connect('/plantas', ['controller' => 'Plantas', 'action' => 'listar']);
    $routes->connect('/plantas/:estado', ['controller' => 'Plantas', 'action' => 'listar'], [
        'pass' => ['estado']
    ]);
    // arte pesca
    $routes->connect('/arte_pesca', ['controller' => 'ArtePesca', 'action' => 'listar']);
    $routes->connect('/arte_pesca/:estado', ['controller' => 'ArtePesca', 'action' => 'listar'], [
        'pass' => ['estado']
    ]);
    // usuarios
    $routes->connect('/usuarios', ['controller' => 'Usuarios', 'action' => 'listar']);
    $routes->connect('/usuarios/:estado', ['controller' => 'Usuarios', 'action' => 'listar'], [
        'pass' => ['estado']
    ]);
    $routes->connect('/usuarios/get_grupo/:username', ['controller' => 'Usuarios', 'action' => 'getGrupo'], [
      'pass' => ['username']
    ]);
    // grupos
    $routes->connect('/grupos', ['controller' => 'Grupos', 'action' => 'listar']);
    $routes->connect('/grupos/:estado', ['controller' => 'Grupos', 'action' => 'listar'], [
        'pass' => ['estado']
    ]);
    // areas
    $routes->connect('/areas', ['controller' => 'Areas', 'action' => 'listar']);
    $routes->connect('/areas/:estado', ['controller' => 'Areas', 'action' => 'listar'], [
      'pass' => ['estado']
    ]);
    // especies
    $routes->connect('/especies', ['controller' => 'Especies', 'action' => 'listar']);
    $routes->connect('/especies/:estado', ['controller' => 'Especies', 'action' => 'listar'], [
        'pass' => ['estado']
    ]);
    //auxiliares
    $routes->connect('/auxiliares', ['controller' => 'Auxiliares', 'action' => 'listar']);
    $routes->connect('/auxiliares/:funcion', ['controller' => 'Auxiliares', 'action' => 'listar'], [
        'pass' => ['funcion']
    ]);
    $routes->connect('/auxiliares/:funcion/:estado', ['controller' => 'Auxiliares', 'action' => 'listar'], [
        'pass' => ['funcion', 'estado']
    ]);
    // divisiones
    $routes->connect('/divisiones', ['controller' => 'Divisiones', 'action' => 'listar']);
    // recursos
    $routes->connect('/recursos', ['controller' => 'Recursos', 'action' => 'listar']);
    $routes->connect('/recursos/:estado', ['controller' => 'Recursos', 'action' => 'listar'], [
        'pass' => ['estado']
    ]);
    // tipodescargas
    $routes->connect('/tipodescargas', ['controller' => 'TipoDescargas', 'action' => 'listar']);
    $routes->connect('/tipodescargas/:estado', ['controller' => 'TipoDescargas', 'action' => 'listar'], [
        'pass' => ['estado']
    ]);
    // movimientos
    $routes->connect('/movimientos', ['controller' => 'Movimientos', 'action' => 'listar']);
    $routes->connect('/movimientos/:estado', ['controller' => 'Movimientos', 'action' => 'listar'], [
        'pass' => ['estado']
    ]);
    // calibres
    $routes->connect('/calibres', ['controller' => 'Calibres', 'action' => 'listar']);
    $routes->connect('/calibres/:estado', ['controller' => 'Calibres', 'action' => 'listar'], [
        'pass' => ['estado']
    ]);
    // ciudades
    $routes->connect('/ciudades', ['controller' => 'Ciudades', 'action' => 'listar']);
    $routes->connect('/ciudades/:estado', ['controller' => 'Ciudades', 'action' => 'listar'], [
        'pass' => ['estado']
    ]);
    // unidades
    $routes->connect('/unidades', ['controller' => 'Unidades', 'action' => 'listar']);
    $routes->connect('/unidades/:estado', ['controller' => 'Unidades', 'action' => 'listar'], [
        'pass' => ['estado']
    ]);
    // regimenes
    $routes->connect('/regimenes', ['controller' => 'Regimenes', 'action' => 'listar']);
    //transportes
    $routes->connect('/transportes', ['controller' => 'Transportes', 'action' => 'listar']);
    $routes->connect('/transportes/:estado', ['controller' => 'Transportes', 'action' => 'listar'], [
        'pass' => ['estado']
    ]);
    // camiones
    $routes->connect('/camiones', ['controller' => 'Camiones', 'action' => 'listar']);
    $routes->connect('/camiones/:estado', ['controller' => 'Camiones', 'action' => 'listar'], [
        'pass' => ['estado']
    ]);
    // tratamientos
    $routes->connect('/tratamientos', ['controller' => 'Tratamientos', 'action' => 'listar']);
    $routes->connect('/tratamientos/:estado', ['controller' => 'Tratamientos', 'action' => 'listar'], [
        'pass' => ['estado']
    ]);

    // Recursos
    $routes->resources('Estados', [
        'only' => ['index']
    ]);

    /** RMP **/
    $routes->resources('Naves', [
      'only' => ['listar_filtrado'],
      'map' => [
        'listar_filtrado' => [
          'action' => 'listar_filtrado',
          'method' => 'GET'
        ]
      ]
    ]);
    $routes->resources('Especies', [
      'only' => ['listar'],
      'map' => [
        'listar' => [
          'action' => 'listar',
          'method' => 'GET'
        ]
      ]
    ]);
    $routes->resources('Puertos', [
      'only' => ['listar_filtrado'],
      'map' => [
        'listar_filtrado' => [
          'action' => 'listar_filtrado',
          'method' => 'GET'
        ]
      ]
    ]);
    $routes->resources('Pontones', [
      'only' => ['listar_filtrado'],
      'map' => [
        'listar_filtrado' => [
          'action' => 'listar_filtrado',
          'method' => 'GET'
        ]
      ]
    ]);
    $routes->resources('Auxiliares', [
      'only' => ['listar_filtrado'],
      'map' => [
        'listar_filtrado' => [
          'action' => 'listar_filtrado',
          'method' => 'GET'
        ]
      ]
    ]);

    /**  CONTROL DE CUOTAS  **/
    $routes->resources('MacroZonas', [
        'only' => ['index', 'obtenerPorNombre', 'obtenerPorEspecie'],
        'map' => [
          'obtenerPorNombre' => [
            'action' => 'obtenerPorNombre',
            'method' => 'GET'
          ],
          'obtenerPorEspecie' => [
            'action' => 'obtenerPorEspecie',
            'method' => 'GET'
          ],
        ]
    ]);
    $routes->resources('ZonasPesca', [
        'only' => ['index', 'obtenerPorEspecie'],
        'map' => [
          'obtenerPorEspecie' => [
            'action' => 'obtenerPorEspecie',
            'method' => 'GET'
          ],
        ]
    ]);
    $routes->resources('Licencias', [
        'only' => ['index', 'obtenerPorNombre'],
        'map' => [
          'obtenerPorNombre' => [
            'action' => 'obtenerPorNombre',
            'method' => 'GET'
          ]
        ]
    ]);
    $routes->resources('TiposLicencia', [
        'only' => ['index']
    ]);
    $routes->resources('Auxiliares', [
        'only' => ['index']
    ]);
    $routes->resources('Decretos', [
        'only' => ['index']
    ]);
    $routes->resources('Operaciones', [
        'only' => ['index', 'listar', 'obtenerTotalPorEspecie', 'comprobarNuevaOperacion'],
        'map' => [
            'listar' => [
                'action' => 'index',
                'method' => ['POST']
            ],
            'obtenerTotalPorEspecie' => [
                'action' => 'obtenerTotalPorEspecie',
                'method' => ['GET']
            ],
            'comprobarNuevaOperacion' => [
                'action' => 'comprobarNuevaOperacion',
                'method' => ['GET']
            ]
        ]
    ]);
    $routes->resources('TipoOperaciones', [
      'only' => ['index', 'obtenerPorNombre'],
      'map' => [
        'obtenerPorNombre' => [
          'action' => 'obtenerPorNombre',
          'method' => 'GET'
        ]
      ]
    ]);
    $routes->resources('EstadoCuotas', [
      'only' => ['index', 'totales_por_mes'],
      'map' => [
        'totales_por_mes' => [
          'action' => 'totales_por_mes',
          'method' => 'GET'
        ]
      ]
    ]);
    $routes->resources('EstadosCuota', [
        'only' => ['index']
    ]);
});

Router::scope('/', function ($routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Usuarios', 'action' => 'login']);
    $routes->connect('/inicio', ['controller' => 'Home', 'action' => 'index']);
    $routes->connect('/guias', ['controller' => 'GuiaEncabezados', 'action' => 'index']);
    $routes->connect('/calidad', ['controller' => 'ControlesCalidad', 'action' => 'index']);
    $routes->connect('/folios', ['controller' => 'FolioEncabezados', 'action' => 'index']);

    // URI para mantener la conexión viva si hay inactividad
    $routes->connect('/keepAlive', ['controller' => 'Usuarios', 'action' => 'keepAlive']);
    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `InflectedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'InflectedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'InflectedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks('InflectedRoute');
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
