/**
 * Vaivera Image Gallery Block - Simple Version
 */

(function () {
    'use strict';

    // Wait for WordPress to be ready
    wp.domReady(function () {
        console.log('Registering Vaivera Image Gallery block...');

        // Check if required functions exist
        if (!wp.blocks || !wp.blocks.registerBlockType) {
            console.error('wp.blocks not available');
            return;
        }

        const { registerBlockType } = wp.blocks;
        const { MediaUpload, MediaPlaceholder, InspectorControls } = wp.blockEditor || wp.editor;
        const { PanelBody, RangeControl, SelectControl, ToggleControl, Button } = wp.components;
        const { __ } = wp.i18n;
        const { createElement: el, Fragment } = wp.element;

        registerBlockType('vaivera/image-gallery', {
            title: __('Vaivera Image Gallery', 'vaivera'),
            icon: 'format-gallery',
            category: 'media',
            description: __('A responsive image gallery with fullscreen lightbox.', 'vaivera'),
            keywords: [
                __('gallery', 'vaivera'),
                __('images', 'vaivera'),
                __('lightbox', 'vaivera')
            ],
            supports: {
                align: ['wide', 'full'],
                html: false
            },
            attributes: {
                images: {
                    type: 'array',
                    default: []
                },
                columns: {
                    type: 'number',
                    default: 3
                },
                spacing: {
                    type: 'string',
                    default: 'medium'
                },
                showCaptions: {
                    type: 'boolean',
                    default: true
                }
            },

            edit: function (props) {
                const { attributes, setAttributes } = props;
                const { images, columns, spacing, showCaptions } = attributes;

                function onSelectImages(newImages) {
                    console.log('Selected images:', newImages);
                    setAttributes({
                        images: newImages.map(function (image) {
                            return {
                                id: image.id,
                                url: image.sizes && image.sizes.medium ? image.sizes.medium.url : image.url,
                                fullUrl: image.url,
                                alt: image.alt || '',
                                caption: image.caption || ''
                            };
                        })
                    });
                }

                // If no images, show placeholder
                if (!images || images.length === 0) {
                    return el(
                        'div',
                        { className: 'wp-block-vaivera-image-gallery' },
                        el(MediaPlaceholder, {
                            icon: 'format-gallery',
                            labels: {
                                title: __('Minimalist Image Gallery', 'minimalist'),
                                instructions: __('Select images to create a gallery with lightbox.', 'minimalist')
                            },
                            onSelect: onSelectImages,
                            accept: 'image/*',
                            allowedTypes: ['image'],
                            multiple: true
                        })
                    );
                }

                // Gallery with images
                return el(
                    Fragment,
                    null,
                    // Inspector Controls
                    el(
                        InspectorControls,
                        null,
                        el(
                            PanelBody,
                            { title: __('Gallery Settings', 'vaivera') },
                            el(RangeControl, {
                                label: __('Columns', 'vaivera'),
                                value: columns,
                                onChange: function (value) {
                                    setAttributes({ columns: value });
                                },
                                min: 1,
                                max: 6
                            }),
                            el(SelectControl, {
                                label: __('Spacing', 'vaivera'),
                                value: spacing,
                                options: [
                                    { label: __('Small', 'vaivera'), value: 'small' },
                                    { label: __('Medium', 'vaivera'), value: 'medium' },
                                    { label: __('Large', 'vaivera'), value: 'large' }
                                ],
                                onChange: function (value) {
                                    setAttributes({ spacing: value });
                                }
                            }),
                            el(ToggleControl, {
                                label: __('Show Captions', 'vaivera'),
                                checked: showCaptions,
                                onChange: function (value) {
                                    setAttributes({ showCaptions: value });
                                }
                            })
                        )
                    ),
                    // Gallery Preview
                    el(
                        'div',
                        {
                            className: 'wp-block-vaivera-image-gallery gallery-columns-' + columns + ' gallery-spacing-' + spacing
                        },
                        el(
                            'div',
                            { className: 'gallery-grid' },
                            images.map(function (image, index) {
                                return el(
                                    'div',
                                    {
                                        key: image.id,
                                        className: 'gallery-item'
                                    },
                                    el(
                                        'div',
                                        { className: 'gallery-image-container' },
                                        el('img', {
                                            src: image.url,
                                            alt: image.alt
                                        })
                                    ),
                                    showCaptions && el(
                                        'div',
                                        { className: 'gallery-caption-editor' },
                                        el('input', {
                                            type: 'text',
                                            placeholder: __('Add caption...', 'minimalist'),
                                            value: image.caption || '',
                                            onChange: function (e) {
                                                const newImages = [...images];
                                                newImages[index].caption = e.target.value;
                                                setAttributes({ images: newImages });
                                            }
                                        })
                                    )
                                );
                            })
                        ),
                        // Edit Gallery Button
                        el(
                            MediaUpload,
                            {
                                onSelect: onSelectImages,
                                allowedTypes: ['image'],
                                multiple: true,
                                gallery: true,
                                value: images.map(function (img) { return img.id; }),
                                render: function (obj) {
                                    return el(
                                        'div',
                                        { style: { textAlign: 'center', marginTop: '1rem' } },
                                        el(Button, {
                                            onClick: obj.open,
                                            className: 'button button-large'
                                        }, __('Edit Gallery', 'vaivera'))
                                    );
                                }
                            }
                        )
                    )
                );
            },

            save: function (props) {
                const { attributes } = props;
                const { images, columns, spacing, showCaptions } = attributes;

                if (!images || images.length === 0) {
                    return null;
                }

                return el(
                    'div',
                    {
                        className: 'wp-block-minimalist-image-gallery gallery-columns-' + columns + ' gallery-spacing-' + spacing
                    },
                    el(
                        'div',
                        {
                            className: 'gallery-grid',
                            'data-lightbox': 'gallery'
                        },
                        images.map(function (image, index) {
                            return el(
                                'div',
                                {
                                    key: image.id,
                                    className: 'gallery-item',
                                    'data-id': image.id,
                                    'data-index': index
                                },
                                el(
                                    'div',
                                    { className: 'gallery-image-container' },
                                    el('img', {
                                        src: image.url,
                                        alt: image.alt,
                                        'data-full': image.fullUrl,
                                        loading: 'lazy'
                                    }),
                                    el(
                                        'div',
                                        { className: 'gallery-overlay' },
                                        el('span', { className: 'gallery-zoom-icon' }, '🔍')
                                    )
                                ),
                                showCaptions && image.caption && el(
                                    'div',
                                    { className: 'gallery-caption' },
                                    image.caption
                                )
                            );
                        })
                    )
                );
            }
        });

        console.log('Minimalist Image Gallery block registered successfully!');
    });

})();