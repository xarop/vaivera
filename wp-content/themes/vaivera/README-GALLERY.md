# Minimalist Image Gallery Block

A beautiful, responsive image gallery with fullscreen lightbox functionality for the Minimalist WordPress theme.

## Features

✅ **Responsive Grid Layout** - Configurable columns (1-6)  
✅ **Fullscreen Lightbox** - Click any image to open in fullscreen  
✅ **Image Slider** - Navigate between images with arrows or keyboard  
✅ **Touch/Swipe Support** - Mobile-friendly navigation  
✅ **Captions** - Optional image captions  
✅ **Keyboard Navigation** - Arrow keys and Escape to close  
✅ **Loading States** - Smooth image loading with spinners  
✅ **Dark/Light Mode** - Matches your theme's color scheme

## How to Use

### Method 1: Shortcode (Easiest)

Add this shortcode to any post or page:

```php
[minimalist_gallery ids="123,124,125,126" columns="3" spacing="medium" captions="true"]
```

**Parameters:**

- `ids` - Comma-separated list of image attachment IDs (required)
- `columns` - Number of columns: 1-6 (default: 3)
- `spacing` - Gap between images: small, medium, large (default: medium)
- `captions` - Show captions: true, false (default: true)

### Method 2: Gutenberg Block

1. In the block editor, click the "+" button
2. Search for "Minimalist Image Gallery"
3. Upload your images using the media library
4. Configure settings in the sidebar:
   - Columns (1-6)
   - Spacing (small/medium/large)
   - Show/hide captions

### Method 3: Find Image IDs

To use the shortcode, you need image attachment IDs:

1. Go to **Media Library** in WordPress admin
2. Click on an image
3. Look at the URL - the ID is the number at the end
4. Example: `post.php?post=123` → ID is `123`

## Examples

### Basic 3-Column Gallery

```php
[minimalist_gallery ids="123,124,125,126,127,128"]
```

### 4-Column Gallery with Large Spacing

```php
[minimalist_gallery ids="123,124,125,126" columns="4" spacing="large"]
```

### 2-Column Gallery without Captions

```php
[minimalist_gallery ids="123,124,125,126" columns="2" captions="false"]
```

### Single Column Gallery (Perfect for Mobile)

```php
[minimalist_gallery ids="123,124,125" columns="1" spacing="large"]
```

## Lightbox Controls

- **Click Image** - Open in fullscreen
- **Arrow Keys** - Navigate between images
- **Escape Key** - Close lightbox
- **Click Background** - Close lightbox
- **Touch/Swipe** - Navigate on mobile devices
- **Close Button (×)** - Close lightbox

## Responsive Behavior

- **Desktop**: Shows configured number of columns
- **Tablet**: 3+ columns become 2 columns
- **Mobile**: 2+ columns become 1 column
- **Touch Devices**: Swipe left/right to navigate in lightbox

## Styling

The gallery inherits your theme's colors and spacing. It automatically adapts to:

- Light/dark mode
- Your theme's border radius
- Your theme's color scheme
- Your theme's typography

## Troubleshooting

### Gallery Not Showing

- Check that image IDs exist and are valid
- Ensure images are uploaded to Media Library
- Verify shortcode syntax is correct

### Lightbox Not Working

- Check browser console for JavaScript errors
- Ensure the theme's JavaScript files are loading
- Try refreshing the page

### Images Not Loading

- Verify image IDs are correct
- Check that images haven't been deleted
- Ensure proper file permissions

## Advanced Usage

### Custom HTML Structure

If you need custom implementation, use this HTML structure:

```html
<div
  class="wp-block-minimalist-image-gallery gallery-columns-3 gallery-spacing-medium"
>
  <div class="gallery-grid" data-lightbox="gallery">
    <div class="gallery-item" data-id="1" data-index="0">
      <div class="gallery-image-container">
        <img
          src="thumbnail.jpg"
          alt="Description"
          data-full="fullsize.jpg"
          loading="lazy"
        />
        <div class="gallery-overlay">
          <span class="gallery-zoom-icon">🔍</span>
        </div>
      </div>
      <div class="gallery-caption">Your caption here</div>
    </div>
    <!-- Repeat for more images -->
  </div>
</div>
```

### CSS Customization

Override styles in your child theme or Customizer:

```css
/* Change hover effect */
.gallery-item:hover {
  transform: translateY(-5px);
}

/* Customize lightbox background */
.minimalist-lightbox {
  background: rgba(0, 0, 0, 0.98);
}

/* Change gallery spacing */
.gallery-spacing-custom .gallery-grid {
  gap: 2rem;
}
```

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

---

**Need Help?** Check the `gallery-example.html` file for a working demo, or contact your theme developer for support.
