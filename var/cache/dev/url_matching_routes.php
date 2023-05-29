<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/formation' => [[['_route' => 'app_formation', '_controller' => 'App\\Controller\\FormationController::index'], null, null, null, false, false, null]],
        '/' => [[['_route' => 'home', '_controller' => 'App\\Controller\\FormationController::home'], null, null, null, false, false, null]],
        '/ajouter' => [[['_route' => 'ajouter', '_controller' => 'App\\Controller\\FormationController::ajouter'], null, null, null, false, false, null]],
        '/participant' => [[['_route' => 'app_participant', '_controller' => 'App\\Controller\\ParticipantController::index'], null, null, null, false, false, null]],
        '/liseteparticipant' => [[['_route' => 'liste_participant', '_controller' => 'App\\Controller\\ParticipantController::afficherList'], null, null, null, false, false, null]],
        '/ajouteparticipant' => [[['_route' => 'ajoute_participant', '_controller' => 'App\\Controller\\ParticipantController::ajouterParticipant'], null, null, null, false, false, null]],
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/formation/([^/]++)(*:26)'
                .'|/modifier(?'
                    .'|/([^/]++)(*:54)'
                    .'|participant/([^/]++)(*:81)'
                .')'
                .'|/s(?'
                    .'|upprimer(?'
                        .'|/([^/]++)(*:114)'
                        .'|participant/([^/]++)(*:142)'
                    .')'
                    .'|howparticipant/([^/]++)(*:174)'
                .')'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:214)'
                    .'|wdt/([^/]++)(*:234)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:280)'
                            .'|router(*:294)'
                            .'|exception(?'
                                .'|(*:314)'
                                .'|\\.css(*:327)'
                            .')'
                        .')'
                        .'|(*:337)'
                    .')'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        26 => [[['_route' => 'app_formation_show', '_controller' => 'App\\Controller\\FormationController::show'], ['id'], null, null, false, true, null]],
        54 => [[['_route' => 'modifier_formation', '_controller' => 'App\\Controller\\FormationController::editFormation'], ['id'], null, null, false, true, null]],
        81 => [[['_route' => 'modifier_participant', '_controller' => 'App\\Controller\\ParticipantController::editParticipant'], ['id'], null, null, false, true, null]],
        114 => [[['_route' => 'supprimer_formation', '_controller' => 'App\\Controller\\FormationController::delete'], ['id'], null, null, false, true, null]],
        142 => [[['_route' => 'supprimer_participant', '_controller' => 'App\\Controller\\ParticipantController::delete'], ['id'], null, null, false, true, null]],
        174 => [[['_route' => 'show_participant', '_controller' => 'App\\Controller\\ParticipantController::show'], ['id'], null, null, false, true, null]],
        214 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        234 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        280 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        294 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        314 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        327 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        337 => [
            [['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
