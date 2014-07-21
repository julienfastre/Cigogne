# Require any additional compass plugins here.

# Tell compass where to find local extensions
# If you followed directions and ran 'gem install modular-scale' comment the next two lines out:
extensions_dir = "./../../../../../vendor/gumbyframework/gumby/sass/extensions"
Compass::Frameworks.register('modular-scale', :path => File.expand_path("#{extensions_dir}/modular-scale"))

# get javascript from gumby
javascripts_path = "./../../../../../vendor/gumbyframework/gumby/js"

# Set this to the root of your project when deployed:
http_path = "/"
css_dir = "./../public/css"
sass_dir = "sass"
images_dir = "./../public/images"
javascripts_dir = "./../public/js"

# add gumby import path
add_import_path "./../../../../../vendor/gumbyframework/gumby/sass"
#add_import_path "./../../../../../vendor/gumbyframework/gumby/sass/extensions"

# You can select your preferred output style here (can be overridden via the command line):
# output_style = :expanded or :nested or :compact or :compressed

# To enable relative paths to assets via compass helper functions. Uncomment:
# relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
# line_comments = false


# If you prefer the indented syntax, you might want to regenerate this
# project again passing --syntax sass, or you can uncomment this:
# preferred_syntax = :sass
# and then run:
# sass-convert -R --from scss --to sass sass scss && rm -rf sass && mv scss sass
