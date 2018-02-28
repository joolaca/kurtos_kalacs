module.exports = function(grunt) {
    grunt.initConfig({
        less: {
            development: {
                options: {
                    comporess: true,
                    sourceMap: true,
                    outputSourceFiles: true,
                    sourceMapURL: 'style.css.map',
                    sourceMapFilename: 'public/css/style.css.map',
                },
                files: {
                    'public/css/style.css': 'public/less/style.less',
                },
            },
            minified: {
                options: {
                    cleancss: true,
                    report: 'min',
                },
                files: {
                    'public/css/style.min.css': 'public/css/style.css',
                },
            },
        },
        concat: {
            options: {
                separator: ';',
            },
            bootstrap: {
                src: [
                    'public/bower_resources/jquery/dist/jquery.js',
                    'public/bower_resources/bootstrap/dist/js/bootstrap.js'
                ],
                dest: 'public/js/bootstrap.js',
            },
        },
        uglify: {
            options: {
                mangle: false
            },
            frontend: {
                files: {
                    'public/js/bootstrap.min.js': 'public/js/bootstrap.js',
                },
            },
        },
        copy: {
            bootstrapfonts: {
                files: [
                    { expand: true, flatten: true, src: ['public/bower_resoures/bootstrap/dist/fonts/*'], dest: 'public/fonts/', filter: 'isFile'},
                ]
            },
            fontawesomefonts: {
                files: [
                    { expand: true, flatten: true, src: ['public/bower_resoures/font-awesome/fonts/*'], dest: 'public/fonts/', filter: 'isFile'},
                ]
            },
        },
        watch: {
            javascript: {
                files: ['public/less/*.less'],
                tasks: ['less'],
                options: {
                    livereload: true,
                },
            },
        },
    });

    // Plugin loading
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-less');

    // Task definition
    grunt.registerTask('dist', ['less', 'concat', 'uglify']);
    grunt.registerTask('default', ['dist']);
};