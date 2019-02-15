<?php

use Kirby\Text\KirbyTag;

$original = KirbyTag::$types['image'];

$attrs = [
    'alt',
    'caption',
    'class',
    'height',
    'imgclass',
    'link',
    'linkclass',
    'rel',
    'target',
    'text',
    'title',
    'width'
];

Kirby::plugin('rasteiner/k3-image-tag', [
    'tags' => [
        'image' => [
            'attr' => $attrs,
            'html' => function ($tag) use ($original, $attrs) {
                $file = $tag->file($tag->value);

                // if the file is not found, fallback to original tag

                if ($file && $snippet = $this->option('imagetag.snippet', false)) {
                    // extract the variables and return the snippet result

                    $vars = [
                        'image' => $file
                    ];

                    return snippet($snippet, array_reduce($attrs, function($all, $one) use($tag) {
                        $all[$one] = $tag->$one;
                        return $all;
                    }, $vars), true);

                } else if($file && $maxWidth = $this->option('imagetag.max-width', false)) {
                    // after having the image resized, fallback to normal tag by passing it the resized image as url

                    $tag->value = $file->resize($maxWidth)->url();

                    $tag->alt = $tag->alt ?? $file->alt()->or(' ')->value();
                    $tag->title = $tag->title ?? $file->title()->value();
                    $tag->caption = $tag->caption ?? $file->caption()->value();

                }

                return ($original['html'])($tag);
            }
        ]
    ]
]);
