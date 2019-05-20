
let colors = {
    'transparent': 'transparent',

    'black': '#141236',

    'grey-dark': '#727477',
    'grey-dark-100': '#646668',
    'grey-dark-200': '#565759',
    'grey-dark-300': '#47484A',
    'grey-dark-400': '#393A3B',
    'grey-dark-500': '#2B2B2D',
    'grey-dark-600': '#1C1D1E',


    'grey': '#BEC5C4',
    'grey-100': '#A6ACAC',
    'grey-200': '#8F9493',
    'grey-300': '#777B7B',
    'grey-400': '#474A4A',
    'grey-500': '#303131',

    'grey-light': '#f0f0f0',
    'grey-lighter': '#F8F9F9',
    'grey-lightest': '#FCFDFD',

    'white': '#ffffff',

    'red': '#CE283D',
    'yellow': '#F5C623',
    'green': '#31C09A',

    'blue': '#5A5CE9',
    'blue-dark': '#06205C',
    'blue-grey': '#6B7C93',
    'blue-linkedin': '#0077B5',
    'blue-facebook': '#3853A1',
    'blue-message': '#3490dc',

    'yellow-imdb': '#E2AB2B',

    'red-error': '#D8000C',
};

module.exports = {
    theme: {
        colors: colors,
        screens: {
            'sm': '576px',
            'md': '768px',
            'lg': '992px',
            'xl': '1200px',
            'sm-only': {'max': '767px'},
            '-xl': {'max': '1200px'},
            '-lg': {'max': '992px'},
            '-md': {'max': '768px'},
        },
        fontFamily: {
            'header': [
                'Montserrat',
                'Helvetica Neue',
                'sans-serif',
            ],
            'body': [
                'Noto Sans',
                'Helvetica Neue',
                'sans-serif',
            ],
            'sans': [
                'system-ui',
                'BlinkMacSystemFont',
                '-apple-system',
                'Segoe UI',
                'Roboto',
                'Oxygen',
                'Ubuntu',
                'Cantarell',
                'Fira Sans',
                'Droid Sans',
                'Helvetica Neue',
                'sans-serif',
            ],
            'serif': [
                'Constantia',
                'Lucida Bright',
                'Lucidabright',
                'Lucida Serif',
                'Lucida',
                'DejaVu Serif',
                'Bitstream Vera Serif',
                'Liberation Serif',
                'Georgia',
                'serif',
            ],
            'mono': [
                'Menlo',
                'Monaco',
                'Consolas',
                'Liberation Mono',
                'Courier New',
                'monospace',
            ],
        },

        fontSize: {
            'xs': '.75rem',     // 12px
            'sm': '.875rem',    // 14px
            'base': '1rem',     // 16px
            'md': '1.125rem',   // 18px
            'lg': '1.5rem',     // 24px
            'xl': '2rem',       // 32px
            '2xl': '2.625rem',  // 42px
            '3xl': '3.5rem',    // 56px
        },

        fontWeight: {
            'hairline': 100,
            'thin': 200,
            'light': 300,
            'normal': 400,
            'medium': 500,
            'semibold': 600,
            'bold': 700,
            'extrabold': 800,
            'black': 900,
        },

        lineHeight: {
            'none': 1,
            'tight': 1.25,
            'normal': 1.5,
            'loose': 2,
        },


        letterSpacing: {
            'tight': '-0.05em',
            'normal': '0',
            'wide': '0.05em',
        },


        textColor: theme => theme('colors'),

        backgroundColor: theme => theme('colors'),

        backgroundSize: {
            'auto': 'auto',
            'cover': 'cover',
            'contain': 'contain',
        },

        borderWidth: {
            default: '1px',
            '0': '0',
            '2': '2px',
            '4': '4px',
            '8': '8px',
        },

        borderColor: theme => ({
                   default: theme('colors.grey-light'),
               ...theme('colors'),
         }),

        borderRadius: {
            'none': '0',
            'sm': '.125rem',
            default: '.25rem',
            'lg': '.5rem',
            'full': '9999px',
        },

        width: {
            'auto': 'auto',
            'px': '1px',
            '1': '0.25rem', //4px
            '2': '0.5rem', //8px
            '3': '0.75rem', //12px
            '4': '1rem', //16px
            '5': '1.25rem',
            '6': '1.5rem', //24px
            '8': '2rem', //32px
            '10': '2.5rem', //40px
            '12': '3rem', //48px
            '16': '4rem', //64px
            '24': '6rem', //96px
            '32': '8rem', //128px
            '48': '12rem', //192px
            '64': '16rem', //256px
            '1/2': '50%',
            '1/3': '33.33333%',
            '2/3': '66.66667%',
            '1/4': '25%',
            '3/4': '75%',
            '1/5': '20%',
            '2/5': '40%',
            '3/5': '60%',
            '4/5': '80%',
            '1/6': '16.66667%',
            '5/6': '83.33333%',
            'full': '100%',
            'screen': '100vw',
        },

        height: {
            'auto': 'auto',
            'none': '0px',
            'px': '1px',
            '1': '0.25rem',
            '2': '0.5rem',
            '3': '0.75rem',
            '4': '1rem',
            '5': '1.25rem',
            '6': '1.5rem',
            '8': '2rem',
            '10': '2.5rem',
            '12': '3rem',
            '16': '4rem',
            '24': '6rem',
            '32': '8rem',
            '48': '12rem',
            '64': '16rem',
            'full': '100%',
            'screen': '100vh',
        },

        minWidth: {
            '0': '0',
            'full': '100%',
        },

        minHeight: {
            '0': '0',
            'full': '100%',
            'screen': '100vh',
        },

        maxWidth: {
            'xs': '20rem',
            'sm': '30rem',
            'md': '40rem',
            'lg': '50rem',
            'xl': '60rem',
            '2xl': '70rem',
            '3xl': '80rem',
            '4xl': '90rem',
            '5xl': '100rem',
            'full': '100%',
        },

        maxHeight: {
            'full': '100%',
            'screen': '100vh',
        },


        padding: {
            'px': '1px',
            '0': '0',
            '1': '0.25rem',//4px
            '2': '0.5rem', //8px
            '3': '0.75rem',//12px
            '4': '1rem', //16px
            '5': '1.125rem', //18
            '6': '1.5rem', //24px
            '8': '2rem', //32px
            '10': '2.5rem',
            '12': '3rem',
            '16': '4rem',
            '20': '5rem',
            '24': '6rem',
            '32': '8rem',
            'md': '3rem', //48px
            'lg': '4rem', //64px
            '66': '66%',
            'full': '100%',
        },

        margin: {
            'auto': 'auto',
            'px': '1px',
            '0': '0',
            '1': '0.25rem',
            '2': '0.5rem',
            '3': '0.75rem',
            '4': '1rem',
            '5': '1.25rem',
            '6': '1.5rem',
            '8': '2rem',
            '10': '2.5rem',
            '12': '3rem',
            '16': '4rem',
            '20': '5rem',
            '24': '6rem',
            '32': '8rem',
            'md': '3rem', //48px
            'lg': '4rem', //64px
            '-px': '1px',
            '-0': '0',
            '-1': '0.25rem',
            '-2': '0.5rem',
            '-3': '0.75rem',
            '-4': '1rem',
            '-5': '1.25rem',
            '-6': '1.5rem',
            '-8': '2rem',
            '-10': '2.5rem',
            '-12': '3rem',
            '-16': '4rem',
            '-20': '5rem',
            '-24': '6rem',
            '-32': '8rem',
        },

        boxShadow: {
            default: '0 2px 4px 0 rgba(81, 105, 155, 0.07), 0 2px 4px 0 rgba(0, 0, 0, .02)',
            'md': '0 14px 14px 0 rgba(81, 105, 155, 0.04), 0 2px 4px 0 rgba(0, 0, 0, .02)',
            'lg': '0 15px 30px 0 rgba(0,0,0,0.11), 0 5px 15px 0 rgba(0,0,0,0.08)',
            'inner': 'inset 0 2px 4px 0 rgba(0,0,0,0.06)',
            'outline': '0 0 0 3px rgba(52,144,220,0.5)',
            'none': 'none',
        },


        zIndex: {
            'auto': 'auto',
            '0': 0,
            '10': 10,
            '20': 20,
            '30': 30,
            '40': 40,
            '50': 50,
        },


        opacity: {
            '0': '0',
            '25': '.25',
            '50': '.5',
            '75': '.75',
            '100': '1',
        },


        fill: {
            'current': 'currentColor',
        },

        stroke: {
            'current': 'currentColor',
        },
    },

    container: {
        center: true,
    },

    variants: {
        appearance: ['responsive'],
        backgroundAttachment: ['responsive'],
        backgroundColor: ['responsive', 'hover', 'focus'],
        backgroundPosition: ['responsive'],
        backgroundRepeat: ['responsive'],
        backgroundSize: ['responsive'],
        borderCollapse: [],
        borderColor: ['responsive', 'hover', 'focus'],
        borderRadius: ['responsive'],
        borderStyle: ['responsive'],
        borderWidth: ['responsive'],
        cursor: ['responsive'],
        display: ['responsive'],
        flexDirection: ['responsive'],
        flexWrap: ['responsive'],
        alignItems: ['responsive'],
        alignSelf: ['responsive'],
        justifyContent: ['responsive'],
        alignContent: ['responsive'],
        flex: ['responsive'],
        flexGrow: ['responsive'],
        flexShrink: ['responsive'],
        float: ['responsive'],
        fontFamily: ['responsive'],
        fontSize: ['responsive'],
        fontWeight: ['responsive', 'hover', 'focus'],
        height: ['responsive'],
        letterSpacing: ['responsive'],
        lineHeight: ['responsive'],
        listStylePosition: ['responsive'],
        listStyleType: ['responsive'],
        margin: ['responsive'],
        maxHeight: ['responsive'],
        maxWidth: ['responsive'],
        minHeight: ['responsive'],
        minWidth: ['responsive'],
        negativeMargin: ['responsive'],
        objectFit: false,
        objectPosition: false,
        opacity: ['responsive'],
        outline: ['focus'],
        overflow: ['responsive'],
        padding: ['responsive'],
        pointerEvents: ['responsive'],
        position: ['responsive'],
        inset: ['responsive'],
        resize: ['responsive'],
        shadows: ['responsive', 'hover', 'focus'],
        fill: [],
        stroke: [],
        tableLayout: ['responsive'],
        textAlign: ['responsive'],
        textColor: ['responsive', 'hover', 'focus'],
        fontStyle: ['responsive'],
        textTransform: ['responsive'],
        textDecoration: ['responsive', 'hover', 'focus'],
        fontSmoothing: ['responsive'],
        userSelect: ['responsive'],
        verticalAlign: ['responsive'],
        visibility: ['responsive'],
        whitespace: ['responsive'],
        wordBreak: ['responsive'],
        width: ['responsive'],
        zIndex: ['responsive'],
    },


    plugins: [
    ]
};
