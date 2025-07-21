/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import {
    MediaUpload,
    MediaPlaceholder,
    InspectorControls,
    BlockControls
} from '@wordpress/block-editor';
import {
    PanelBody,
    RangeControl,
    SelectControl,
    ToggleControl,
    Button,
    ToolbarGroup,
    ToolbarButton
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { gallery, trash, edit } from '@wordpress/icons';

/**
 * Internal dependencies
 */
import './editor.css';

registerBlockType('minimalist/image-gallery', {
    edit: ({ attributes, setAttributes }) => {
        const { images, columns, spacing, showCaptions } = attributes;

        const onSelectImages = (newImages) => {
            setAttributes({
                images: newImages.map(image => ({
                    id: image.id,
                    url: image.sizes?.medium?.url || image.url,
                    fullUrl: image.url,
                    alt: image.alt,
                    caption: image.caption
                }))
            });
        };

        const onRemoveImage = (indexToRemove) => {
            setAttributes({
                images: images.filter((_, index) => index !== indexToRemove)
            });
        };

        const onMoveImage = (oldIndex, newIndex) => {
            const newImages = [...images];
            newImages.splice(newIndex, 0, newImages.splice(oldIndex, 1)[0]);
            setAttributes({ images: newImages });
        };

        const updateImageCaption = (index, caption) => {
            const newImages = [...images];
            newImages[index].caption = caption;
            setAttributes({ images: newImages });
        };

        if (!images.length) {
            return (
                <div className="wp-block-minimalist-image-gallery">
                    <MediaPlaceholder
                        icon={gallery}
                        labels={{
                            title: __('Minimalist Image Gallery', 'minimalist'),
                            instructions: __('Select images to create a beautiful gallery with lightbox functionality.', 'minimalist')
                        }}
                        onSelect={onSelectImages}
                        accept="image/*"
                        allowedTypes={['image']}
                        multiple
                    />
                </div>
            );
        }

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__('Gallery Settings', 'minimalist')}>
                        <RangeControl
                            label={__('Columns', 'minimalist')}
                            value={columns}
                            onChange={(value) => setAttributes({ columns: value })}
                            min={1}
                            max={6}
                        />
                        <SelectControl
                            label={__('Spacing', 'minimalist')}
                            value={spacing}
                            options={[
                                { label: __('Small', 'minimalist'), value: 'small' },
                                { label: __('Medium', 'minimalist'), value: 'medium' },
                                { label: __('Large', 'minimalist'), value: 'large' }
                            ]}
                            onChange={(value) => setAttributes({ spacing: value })}
                        />
                        <ToggleControl
                            label={__('Show Captions', 'minimalist')}
                            checked={showCaptions}
                            onChange={(value) => setAttributes({ showCaptions: value })}
                        />
                    </PanelBody>
                </InspectorControls>

                <BlockControls>
                    <ToolbarGroup>
                        <MediaUpload
                            onSelect={onSelectImages}
                            allowedTypes={['image']}
                            multiple
                            gallery
                            value={images.map(img => img.id)}
                            render={({ open }) => (
                                <ToolbarButton
                                    onClick={open}
                                    icon={edit}
                                    label={__('Edit Gallery', 'minimalist')}
                                />
                            )}
                        />
                    </ToolbarGroup>
                </BlockControls>

                <div className={`wp-block-minimalist-image-gallery gallery-columns-${columns} gallery-spacing-${spacing}`}>
                    <div className="gallery-grid">
                        {images.map((image, index) => (
                            <div key={image.id} className="gallery-item" data-index={index}>
                                <div className="gallery-image-container">
                                    <img
                                        src={image.url}
                                        alt={image.alt}
                                        data-full={image.fullUrl}
                                    />
                                    <div className="gallery-item-controls">
                                        <Button
                                            onClick={() => onRemoveImage(index)}
                                            icon={trash}
                                            label={__('Remove Image', 'minimalist')}
                                            className="gallery-remove-button"
                                        />
                                    </div>
                                </div>
                                {showCaptions && (
                                    <div className="gallery-caption-editor">
                                        <input
                                            type="text"
                                            placeholder={__('Add caption...', 'minimalist')}
                                            value={image.caption || ''}
                                            onChange={(e) => updateImageCaption(index, e.target.value)}
                                        />
                                    </div>
                                )}
                            </div>
                        ))}
                    </div>
                </div>
            </>
        );
    },

    save: ({ attributes }) => {
        const { images, columns, spacing, showCaptions } = attributes;

        if (!images.length) {
            return null;
        }

        return (
            <div className={`wp-block-minimalist-image-gallery gallery-columns-${columns} gallery-spacing-${spacing}`}>
                <div className="gallery-grid" data-lightbox="gallery">
                    {images.map((image, index) => (
                        <div key={image.id} className="gallery-item" data-id={image.id} data-index={index}>
                            <div className="gallery-image-container">
                                <img
                                    src={image.url}
                                    alt={image.alt}
                                    data-full={image.fullUrl}
                                    loading="lazy"
                                />
                                <div className="gallery-overlay">
                                    <span className="gallery-zoom-icon">🔍</span>
                                </div>
                            </div>
                            {showCaptions && image.caption && (
                                <div className="gallery-caption">{image.caption}</div>
                            )}
                        </div>
                    ))}
                </div>
            </div>
        );
    }
});