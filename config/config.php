<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2018/7/2
 * Time: 下午2:10
 */

return [
    'debug' => true,
    'log' => [
        'name' => 'qq_clound',
        'path' => dirname(__FILE__)."/../log"
    ],
    'app_id' => 'xxxxxxxx',
    'secret_id' => 'xxxxxxxx',
    'secret_key' => 'xxxxxxxxx',
    'region' => 'sh',
    'cos' => [
        'buckets' => [
            'king'
        ]
    ]
];