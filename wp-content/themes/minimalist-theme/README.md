# Minimalist WordPress Theme

A fast, minimalist, and responsive WordPress theme with full Gutenberg support and translation-ready features.

## Features

### 🎨 Design & Performance

- **Minimalist Design**: Clean, modern interface focused on content
- **Fully Responsive**: Mobile-first design that works on all devices
- **Fast Loading**: Optimized for performance with minimal CSS/JS
- **CSS Variables**: Easy customization through CSS custom properties
- **Dark Mode Support**: Automatic dark mode based on user preference

### 🔧 WordPress Integration

- **Gutenberg Ready**: Full block editor support with custom styling
- **Translation Ready**: Complete i18n support with .pot file included
- **SEO Optimized**: Clean HTML5 structure and proper meta tags
- **Accessibility**: WCAG compliant with proper focus states
- **Custom Logo Support**: WordPress customizer integration

### 📱 Responsive Features

- Mobile-optimized navigation
- Flexible grid system
- Optimized typography scaling
- Touch-friendly interface elements

## Installation

1. Download the theme files
2. Upload the `minimalist-theme` folder to `/wp-content/themes/`
3. Activate the theme in WordPress Admin → Appearance → Themes
4. Customize colors in Appearance → Customize → Theme Colors

## CSS Variables Configuration

The theme uses CSS custom properties for easy customization. You can override these in your child theme:

```css
:root {
  /* Colors */
  --color-primary: #333;
  --color-secondary: #666;
  --color-accent: #333;
  --color-background: #fff;

  /* Typography */
  --font-family-base: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
    sans-serif;
  --font-size-base: 1rem;
  --line-height-base: 1.6;

  /* Spacing */
  --spacing-sm: 1rem;
  --spacing-lg: 2rem;
  --spacing-xl: 3rem;

  /* Layout */
  --container-max-width: 1200px;
  --border-radius: 4px;
}
```

## Translation

The theme is translation-ready. To translate:

1. Copy `languages/minimalist.pot` to `languages/minimalist-[locale].po`
2. Translate the strings using a tool like Poedit
3. Generate the `.mo` file
4. Place both files in the `languages/` directory

## Customization

### Theme Customizer

- **Primary Color**: Main text and accent color
- **Accent Color**: Buttons and interactive elements

### Supported Post Formats

- Standard posts
- Featured images
- Categories and tags
- Post navigation

### Gutenberg Blocks

Full support for all core Gutenberg blocks with custom styling:

- Paragraphs and headings
- Images and galleries
- Quotes and lists
- Groups and columns
- Wide and full-width alignments

## File Structure

```
minimalist-theme/
├── style.css           # Main stylesheet with CSS variables
├── functions.php       # Theme functions and setup
├── index.php          # Blog homepage
├── single.php         # Single post template
├── page.php           # Static page template
├── search.php         # Search results template
├── 404.php            # Error page template
├── header.php         # Site header
├── footer.php         # Site footer
├── editor-style.css   # Gutenberg editor styles
├── languages/         # Translation files
│   └── minimalist.pot # Translation template
└── README.md          # This file
```

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## Performance Features

- Lazy loading images
- Minimal HTTP requests
- Optimized CSS delivery
- Disabled unnecessary WordPress features
- Clean, semantic HTML

## License

This theme is licensed under the GPL v2 or later.

## Support

For support and customization, please refer to the WordPress documentation or contact the theme developer.

---

**Version**: 1.0  
**Requires WordPress**: 5.0+  
**Tested up to**: 6.4  
**License**: GPLv2 or later
