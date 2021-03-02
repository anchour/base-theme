<?php

namespace App;

use Roots\Sage\Container;

/**
 * Get the sage container.
 *
 * @param string $abstract
 * @param array  $parameters
 * @param Container $container
 * @return Container|mixed
 */
function sage($abstract = null, $parameters = [], Container $container = null)
{
    $container = $container ?: Container::getInstance();
    if (!$abstract) {
        return $container;
    }
    return $container->bound($abstract)
        ? $container->makeWith($abstract, $parameters)
        : $container->makeWith("sage.{$abstract}", $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param array|string $key
 * @param mixed $default
 * @return mixed|\Roots\Sage\Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return sage('config');
    }
    if (is_array($key)) {
        return sage('config')->set($key);
    }
    return sage('config')->get($key, $default);
}

/**
 * @param string $file
 * @param array $data
 * @return string
 */
function template($file, $data = [])
{
    return sage('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view
 * @param $file
 * @param array $data
 * @return string
 */
function template_path($file, $data = [])
{
    return sage('blade')->compiledPath($file, $data);
}

/**
 * @param $asset
 * @return string
 */
function asset_path($asset)
{
    return sage('assets')->getUri($asset);
}

/**
 * @param string|string[] $templates Possible template files
 * @return array
 */
function filter_templates($templates)
{
    $paths = apply_filters('sage/filter_templates/paths', [
        'views',
        'resources/views'
    ]);
    $paths_pattern = "#^(" . implode('|', $paths) . ")/#";

    return collect($templates)
        ->map(function ($template) use ($paths_pattern) {
            /** Remove .blade.php/.blade/.php from template names */
            $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

            /** Remove partial $paths from the beginning of template names */
            if (strpos($template, '/')) {
                $template = preg_replace($paths_pattern, '', $template);
            }

            return $template;
        })
        ->flatMap(function ($template) use ($paths) {
            return collect($paths)
                ->flatMap(function ($path) use ($template) {
                    return [
                        "{$path}/{$template}.blade.php",
                        "{$path}/{$template}.php",
                    ];
                })
                ->concat([
                    "{$template}.blade.php",
                    "{$template}.php",
                ]);
        })
        ->filter()
        ->unique()
        ->all();
}

/**
 * @param string|string[] $templates Relative path to possible template files
 * @return string Location of the template
 */
function locate_template($templates)
{
    return \locate_template(filter_templates($templates));
}

/**
 * Gets all the module attributes on the wrapping <section> item.
 *
 * @param string $layout
 *
 * @return string
 */
function module_attributes($layout = '')
{
    $attrs = collect(['class' => 'module ' . $layout, 'data-section-type' => $layout]);

    $attrs = apply_filters('App/module_attributes', $attrs->filter()->toArray(), $layout);

    return esc_html_attributes($attrs);
}

/**
 * This function will escape an array of attributes and return as HTML.
 * Taken from ACF plugin.
 *
 * @param array $atts
 *
 * @return string
 */
function esc_html_attributes($atts = [])
{
    $html = '';

    foreach ($atts as $k => $v) {
        if (is_string($v)) {
            $v = trim($v);
        } elseif (is_bool($v)) {
            $v = $v ? 1 : 0;
        } elseif (is_array($v) || is_object($v)) {
            $v = json_encode($v);
        }

        $html .= esc_attr($k) . '="' . esc_attr($v) . '" ';
    }

    return trim($html);
}

/**
 * Gets parameters for a 'link' sub-field based on whether or not the field is
 * output as an array or a string.
 *
 * @return string
 */
function link_attributes($link = false, array $params = [])
{
    if (!$link) {
        $link = get_sub_field('link');
    }

    if (!$link) {
        return '';
    }

    $atts = [];

    if (is_array($link)) {
        $atts['href'] = $link['url'];
        $atts['title'] = $link['title'];
        $atts['target'] = $link['target'];
    } else {
        $atts['href'] = $link;
    }

    $targetHost = parse_url($atts['href'], PHP_URL_HOST);
    $currentHost = $_SERVER['HTTP_HOST'];

    if (!is_null($targetHost) && $targetHost != $currentHost) {
        $atts['target'] = '_blank';
    }

    $atts = array_filter($atts);

    if (!empty($params)) {
        $params = array_map(function ($value, $key) {
            return "{$key}={$value}";
        }, array_values($params), array_keys($params));

        $queryString = implode('&', $params);

        $atts['href'] .= (strpos($atts['href'], '?') !== false ? '&' : '?') . $queryString;
    }

    $atts['href'] = esc_url_raw($atts['href']);

    return esc_html_attributes($atts);
}

/**
 * Get the contents of the asset provided. Uses the manifest.json
 * file to retrieve contents that is output by the webpack
 * build system, if present. Otherwise, retrieves files
 * by their filename/directory. Realistically, this should only
 * be used for SVG files within the theme directory.
 *
 * @param  string $path
 *
 * @return string
 */
function output_asset_contents($path = '')
{
    if (!$path) {
        return '';
    }

    $fullpath = dirname(get_stylesheet_directory()) . '/dist/' . sage('assets')->get($path);

    if (!file_exists($fullpath)) {
        return '';
    }

    return file_get_contents($fullpath);
}
