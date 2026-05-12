<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        =>'Shundorjo | Authentic Skincare & Health Products in Bangladesh', // set false to total remove
            'titleBefore'  => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description'  => 'Shundorjo offers premium cosmetics, skincare, medicated products & health care. Authentic brands, best prices & fast delivery all over Bangladesh!', // set false to total remove
            'separator'    => ' | ',
            'keywords' => [
    'shundorjo', 'skincare Bangladesh', 'authentic cosmetics', 'medicated skincare', 'online beauty shop',
    'organic beauty products', 'anti acne solution', 'hair fall treatment', 'face wash Bangladesh',
    'cerave Bangladesh', 'dot & key', 'cetaphil', 'sunscreen Bangladesh', 'vitamin C serum',
    'original beauty products', 'best face cream BD', 'health & wellness', 'body lotion BD',
    'moisturizer for dry skin', 'makeup Bangladesh', 'e-commerce beauty products'
],
            'canonical'    => 'full', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots'       => 'index, follow', // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'Shundorjo Care | Medicated Care Shop In Bangladesh', // set false to total remove
            'description' => 'Buy authentic skincare, cosmetics, and health care products at Shundorjo.com. Trusted brands, best prices, and fast delivery across Bangladesh.', // set false to total remove
            'url'         => '', // Set null for using Url::current(), set false to total remove
            'type'        => false,
            'site_name'   => false,
            'images'      => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            //'card'        => 'summary',
            //'site'        => '@LuizVinicius73',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => 'Shundorjo Care | Medicated Care Shop In Bangladesh', // set false to total remove
            'description' => 'Buy authentic skincare, cosmetics, and health care products at Shundorjo.com. Trusted brands, best prices, and fast delivery across Bangladesh.', // set false to total remove
            'url'         => false, // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'type'        => 'Website',
            'images'      => [],
        ],
    ],
];
