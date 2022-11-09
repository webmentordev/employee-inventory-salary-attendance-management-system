module.exports = {
  content: [    
  "./resources/**/*.blade.php",    
  "./resources/**/*.js",    
  "./resources/**/*.vue",  
],
  theme: {
    extend: {
      width: {
        'form': '380px',
        'avatar': '80px',
        'setup': '450px',
      },
      height:{
        'avatar': '80px',
      },
      padding: {
        'select': '10px',
        'stat': '4px',
        'left': '6px',
      },
      animation: {
        'spin-slow': 'spin 3s linear infinite',
      }
    },
  },
  plugins: [],
}
