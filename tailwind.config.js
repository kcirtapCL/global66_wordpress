module.exports = {
    content: ["**/*.php", "*.php"],
    theme: {
        extend: {
            height: {
                100: "28rem"
            },
            boxShadow: {
                1: "10px 30px 90px rgba(39, 70, 199, .1)",
                2: "0 2px 10px rgba(0, 0, 0, .04)",
                3: "0 5px 17px rgba(52, 62, 104, .2)"
            },
            transitionProperty: {
                maxHeight: "max-height"
            }
        },
        colors: {
            primary: {
                1: "#102A97",
                2: "#1433B4",
                3: "#2746C7",
                4: "#3F5EDF",
                5: "#869EFF",
                6: "#9DB0FF"
            },
            neutral: {
                1: "#343E68",
                2: "#475694",
                3: "#5D6EB5",
                4: "#8B97CB",
                5: "#9AA5D3",
                6: "#B3BDE5",
                7: "#D7DCF0",
                8: "#E1E5F5",
                9: "#F4F6FE",
                10: "#F5F7FF",
                11: "#FAFBFF",
                12: "#FFFFFF"
            },
            accent: {
                1: "#00B682",
                2: "#00C48C",
                3: "#01D196",
                4: "#7CDFC5",
                5: "#DDF2F3"
            },
            semantic: {
                1: "#FF647C",
                2: "#FFB1BD",
                3: "#FFEFF2",
                4: "#FFD153",
                5: "#FCE5A9",
                6: "#FFFAEE"
            },
            transparent: "transparent"
        },
        container: {
            center: true,
            padding: '1rem'
        },
        fontFamily: {
            body: ["Montserrat", "sans-serif"],
            alternate: ["Montserrat Alternates", "sans-serif"]
        }
    }
}
