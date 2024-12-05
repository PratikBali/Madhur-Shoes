<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parallax Scrolling Website</title>
    <link rel="stylesheet" type="text/css" href="about_material/css/about.css">
  </head>
  <body>
    <header>
      <a href="about.php" class="logo">OKISPL</a>
      <ul class="navigation">
        <li><a href="about.php" class="active">About</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
        <li><a href="email.php">Reset Password</a></li>
      </ul>
    </header>
    <section class="parallax">
      <h2 id="text">Welcome to OKISPL</h2>
      <img src="about_material/images/monutain_01.png" id="m1">
      <img src="about_material/images/trees_02.png" id="t2">
      <img src="about_material/images/monutain_02.png" id="m2">
      <img src="about_material/images/trees_01.png" id="t1">
      <img src="about_material/images/man.png" id="man">
      <img src="about_material/images/plants.png" id="plants">
    </section>
    <section class="sec">
      <h2>Om Kalyani IT Solution Pvt.ltd. </h2>
      <p>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        "Okispl is a rapidly growing Software Development Services company based in BARAMATI, India.
         Since 2021, we have worked hard to achieve several milestones and we works only on Open 
         Source Technologies. Our team of expert Developers have satisfactorily served more than 25 
         clients from across the globe, offering state-of-the-art software solutions designed to 
         meet their specific requirements. We believe that undue attention to detail and 
         professionalism are the keys for success and that’s what we offer to each of our clients.”
      </p>
      <p style="margin-top: 5%">
        More Information Visit - 
        <a href="https://www.okispl.com" style="color:aqua">Om Kalyani IT Solution Pvt.ltd.</a>
      </p>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.1/ScrollTrigger.min.js"></script>
    <script>
      gsap.from("#m1",{
        scrollTrigger : {
          scrub: true
        },
        y: 100,
      })
      gsap.from("#m2",{
        scrollTrigger : {
          scrub: true
        },
        y: 50,
      })
      gsap.from("#t2",{
        scrollTrigger : {
          scrub: true
        },
        x: -50,
      })
      gsap.from("#t1",{
        scrollTrigger : {
          scrub: true
        },
        x: 50,
      })
      gsap.from("#man",{
        scrollTrigger : {
          scrub: true
        },
        x: -250,
      })
      gsap.from("#plants",{
        scrollTrigger : {
          scrub: true
        },
        x: -50,
      })
      gsap.from("#text",{
        scrollTrigger : {
          scrub: true
        },
        x: 600,
      })
    </script>
  </body>
</html>