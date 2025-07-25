# Vaivera WordPress Theme

A fast, minimalist, and responsive WordPress theme with full Gutenberg support, dark/light mode toggle, and modern architectural portfolio design.

## Features

### 🎨 Design & Performance

- **Architectural Portfolio Design**: Clean, modern interface designed for architecture and design portfolios
- **Fully Responsive**: Mobile-first design that works on all devices
- **Fast Loading**: Optimized for performance with minimal CSS/JS
- **CSS Variables**: Easy customization through CSS custom properties
- **Dark/Light Mode Toggle**: Manual theme switching with automatic preference detection
- **Modular Architecture**: Reusable partial templates and semantic CSS components

### 🔧 WordPress Integration

- **Gutenberg Ready**: Full block editor support with custom styling
- **Custom Post Types**: Built-in support for projects with category filtering
- **Translation Ready**: Complete i18n support with .pot file included
- **SEO Optimized**: Clean HTML5 structure and proper meta tags
- **Accessibility**: WCAG compliant with proper focus states
- **Custom Menus**: Primary navigation and footer menu support
- **Homepage Carousel**: Full-screen image carousel with navigation controls

### 📱 Responsive Features

- Mobile-optimized navigation with collapsible header
- Flexible grid system for project galleries
- Optimized typography scaling with Inter font
- Touch-friendly carousel navigation
- Responsive image alignment classes
- Mobile-first responsive breakpoints

### 🏗️ Portfolio Features

- **Project Archive System**: Filterable project grid with category support
- **Card-based Layout**: Modern card design for project display
- **Gallery Slider**: Modal gallery with navigation controls
- **Category Filtering**: JavaScript-powered project filtering
- **Modular Partials**: Reusable template components
- **Semantic CSS**: Component-based styling architecture

## Installation

1. Download the theme files
2. Upload the `vaivera` folder to `/wp-content/themes/`
3. Activate the theme in WordPress Admin → Appearance → Themes
4. Configure homepage carousel images in the page editor
5. Set up project categories and create project posts

## CSS Variables Configuration

The theme uses CSS custom properties for easy customization. You can override these in your child theme:

```css
:root {
  /* Colors - Light Mode */
  --color-primary: #c9612c;
  --color-secondary: #4b62a7;
  --color-text: #4b62a7;
  --color-text-light: #6d80b9;
  --color-background: #fbfaf6;
  --color-border: #e9e7e0;
  --color-accent: #c9612c;

  /* Typography */
  --font-family-base: 'Inter', sans-serif;
  --font-size-base: 1rem;
  --font-size-large: 1.5rem;
  --font-size-xl: 2rem;
  --line-height-base: 1.6;

  /* Spacing */
  --spacing-xs: 0.5rem;
  --spacing-sm: 1rem;
  --spacing-md: 1.5rem;
  --spacing-lg: 2rem;
  --spacing-xl: 3rem;

  /* Layout */
  --container-max-width: 1200px;
  --content-max-width: 800px;
  --border-radius: 4px;

  /* Transitions */
  --transition-fast: 0.3s ease;
}

/* Dark Mode Variables */
[data-theme="dark"] {
  --color-primary: #e9a980;
  --color-secondary: #8a9bd0;
  --color-text: #ccc;
  --color-background: #1a1a1a;
  --color-border: #333;
}
```

## Theme Setup

### Homepage Configuration

1. **Set Static Homepage**: Go to Settings → Reading and set homepage to a static page
2. **Carousel Images**: Add a gallery block to your homepage content for the carousel
3. **Homepage Content**: Content will display in the right column below the carousel

### Project Setup

1. **Create Project Categories**: Go to Projects → Categories and add your project types
2. **Add Projects**: Create new projects with featured images and assign categories
3. **Project Archive**: Projects will automatically display on the homepage and archive page

### Menu Configuration

1. **Primary Menu**: Configure in Appearance → Menus (displays in header)
2. **Footer Menu**: Create a footer menu for the site footer
3. **Menu Locations**: Assign menus to their respective locations

## Translation

The theme is translation-ready. To translate:

1. Copy `languages/vaivera.pot` to `languages/vaivera-[locale].po`
2. Translate the strings using a tool like Poedit
3. Generate the `.mo` file
4. Place both files in the `languages/` directory

## Customization

### Dark/Light Mode

- **Automatic Detection**: Theme respects user's system preference
- **Manual Toggle**: Fixed toggle button in top-right corner
- **CSS Variables**: All colors automatically adapt to selected theme

### Supported Post Types

- **Standard Posts**: Blog posts with featured images
- **Projects**: Custom post type with category filtering
- **Pages**: Static pages with flexible content layout
- **Categories and Tags**: Full taxonomy support

### Gutenberg Blocks

Full support for all core Gutenberg blocks with custom styling:

- Paragraphs and headings with primary color scheme
- Images with responsive alignment classes
- Blockquotes with accent border styling
- Lists with proper indentation and spacing
- Groups and columns with semantic styling
- Wide and full-width alignments

## File Structure

```
vaivera/
├── style.css              # Main stylesheet with CSS variables
├── functions.php          # Theme functions and setup
├── index.php             # Blog homepage
├── front-page.php        # Custom homepage with carousel
├── single.php            # Single post template
├── page.php              # Static page template
├── search.php            # Search results template
├── 404.php               # Error page template
├── archive-project.php   # Project archive template
├── single-project.php    # Single project template
├── header.php            # Site header
├── footer.php            # Site footer with menu support
├── editor-style.css      # Gutenberg editor styles
├── css/
│   ├── project-archive.css   # Project-specific styles
│   ├── gallery-slider.css    # Gallery modal styles
│   └── unified-slider.css    # Carousel navigation styles
├── partials/
│   ├── projects-archive.php  # Reusable projects display
│   └── project-card.php      # Individual project card
├── languages/
│   └── vaivera.pot           # Translation template
└── README.md                 # This file
```

## Performance Features

- Inter font from Google Fonts with display=swap
- Minimal HTTP requests with consolidated CSS
- Optimized CSS delivery with component-based architecture
- Semantic HTML5 structure for better performance
- CSS variables for reduced file size
- Modular partial templates for code reusability
- Admin bar overflow management for better mobile experience

## Technical Features

### CSS Architecture

- **Component-based CSS**: Semantic classes and modular styling
- **CSS Grid & Flexbox**: Modern layout techniques
- **CSS Variables**: Theme-wide consistency and easy customization
- **Mobile-first**: Responsive design with progressive enhancement
- **No borders**: Clean, borderless card design

### JavaScript Features

- **Project Filtering**: Category-based filtering with smooth transitions
- **Carousel Navigation**: Touch and keyboard accessible controls
- **Theme Toggle**: Persistent dark/light mode switching
- **Gallery Modal**: Interactive image viewing experience

### WordPress Integration

- **Custom Post Types**: Projects with category taxonomy
- **Menu Locations**: Primary and footer menu support
- **Widget Areas**: Sidebar and footer widget support
- **Customizer Support**: Theme options integration
- **Template Hierarchy**: Proper WordPress template structure

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## License

This theme is licensed under the GPL v2 or later.

## Support

For support and customization, please refer to the WordPress documentation or contact the theme developer at xarop.com.

---

**Theme Name**: Vaivera  
**Version**: 1.0  
**Author**: xarop.com  
**Requires WordPress**: 5.0+  
**Tested up to**: 6.4  
**License**: GPLv2 or later  
**Text Domain**: vaivera
