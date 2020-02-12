const blueColor = {
  default: 'hsl(222,13%,15%)',
  500: 'hsl(222,13%,15%)'
};

const taupeColor = {
  default: 'hsl(37,48%,87%)',
  500: 'hsl(37,48%,87%)'
}

module.exports = {
  theme: {
    extend: {},
    colors: {
      primary: {...blueColor},
      secondary: {...taupeColor},
      blue: {...blueColor},
      taupe: {...taupeColor}
    },
  },
  variants: {},
  plugins: [],
}
