@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;600;700;900&display=swap");

/* GLOBAL */
#wpcontent {
  padding-left: 0 !important;
}

#wpfooter {
  display: none;
}

#wpbody {
  position: relative;
  background-color: #f5f5f5;
  transition-property: all;
  transition-duration: 0.3s;
}

html,
body {
  font-family: "Roboto", sans-serif;
  font-size: 16px;
  color: #505353;
  transition-property: color;
  transition-duration: 0.5s;
  box-sizing: border-box;
  scroll-behavior: smooth;
}

* {
  margin: 0;
  padding: 0;
}

*:focus {
  outline: none;
  border-color: inherit;
  -webkit-box-shadow: none;
  box-shadow: none;
}

h1 {
  color: #505353;
  font-weight: 900;
  font-size: 60px;
  margin-bottom: 40px;
  display: inline-block;
}

.container {
  width: 100%;
  padding: 15px;
  box-sizing: border-box;
}

.d-none {
  display: none;
}