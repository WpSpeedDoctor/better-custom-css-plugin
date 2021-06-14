# Better Custom CSS plugin

The Better Custom CSS plugin is here to help faster websites and more lightweight websites.

The most common mistake when WordPress users are adjusting CSS on their website is to add CSS into the Appearance/Additional CSS menu, theme options box for CSS or to single one CSS stylesheet in the child theme. That makes unnecessary bloat, loads all CSS on all pages regardless it's needed or not. It's an old-style creating CSS coming back to beginnings when speed wasn't measured and wasn't taken into account.

If you want to have top speed on mobile devices you have to load the least amount of styles on a given page. Why? Because CSS ( and even more JS ) have to be processed every time and on low-tier mobiles with slower CPU that will take significantly more rendering time. Just processing could be even 2-3 seconds longer than on top-tier mobiles or desktop computers. The best practice is to have one style that has all styles that are general for all website like styles for header, footer, headers, body text, etc., and on templates and individual pages load styles that are related to a given template or page.

This plugin is here to make separate CSS files that load only on pages or pages using a separate template.

Installation:
```
1. upload and activate plugin
2. Use admin bar menu Better Custom CSS to create a separate CSS file for the website.
```
Once plugin is active you can see a new menu in admin bar (only for admin users) you can see what options are available for the given page you're currently on. All new CSS files will be created in ```/wp-content/uploads/better-custom-css``` folder.

These files you can edit with plugin like ACEIDE or File Manager. Just place your CSS code there and it will be automatically loaded on corresponding pages.

Individual pages can have loaded separate CSS file as a unique request or can be inlined. The inlined option is there if you need to adjust something very small, under 1kb of code. If it's larger, I recommend using file instead of inline.

For debugging purposes, I have included a debugging window. It will display the type and file path of files that been loaded. If files for a given page or template wasn't created, it will show the text 'Not present'.

It's easy to come back and recognise in what file your CSS is stored. Files starting with the type (inline, page, template) and then when applicable the page ID, for example page-1.css, woocommerce-product-category.css, template-blue-background.css.  

The plugin supports Woocommerce and offers to create a general template for Woocommerce and separate Woocommerce related pages like a product, cart, checkout or product gallery.

The priority of styles are the following:
```
1.Inline
2.Page
3.Template
```
For example, if you have template CSS loaded and then you add individual page CSS, styles in the individual CSS file will have higher priority than template CSS styles. No more using "!important"!

Here is the video on how it works and how to use it. (video update needed, made for older version, still valid for latest version)

[![Watch the video](https://wpspeeddoctor.com/wp-content/uploads/video-preview/video-preview.jpg)](https://www.youtube.com/watch?v=1gxJ1xweiXc)


# Move plugin into the child theme!
After you set your custom CSS go in WP admin menu Settings/Better custom CSS where you'll get the command you need to place in child theme in order to run it as a part of the child theme. So di this steps:

1. Go to Settings/Better custom CSS
2. Copy PHP command for child theme, starting with: ```require_once ( trailingslashit( get_theme_file_path() )```
3. Deactivate Better custom CSS plugin
4. Use file manager to move plugin folder ```wp-content/plugins/better-custom-css-main``` to child theme folder in ```/wp-content/themes/YOUR-CHILD-THEME```
5. Edit functions.php file in the child theme, add text you have copied on point 2.
6. If you have created CSS files before migrating to child theme, you need to move your CSS files from ```/wp-content/uploads/better-custom-css``` to ```/wp-content/themes/your-child-theme/assets/css/```

Now the plugin's settings menu will be in Appearance. 

Quick tip:
Regarding the general style of the child theme, my recommendation is to:
```
1. Not to load (disable) the parent main stylesheet
2. Manually copy styles from parent style.css to child-theme style.css
3. Filter the parent theme CSS by removing parts that are not used on your type of website
```
An example of filtering would be if you have a blog and parent style.css contain CSS styles for Woocommerce, but you don't use Woocommerce, then just delete the Woocommerce part. This way you can save easily 20% of its original size.

Any feedback or improment tips are welcome on email pixtweaks at protonmail.com

I hope it will make your life easier and your website faster to load on slow mobile devices. Enjoy!
