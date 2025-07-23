

<!--</div> end of content |-->

</div><!-- end of container |-->

</main>
<footer class="footer mt-auto py-3 bg-body-tertiary  sticky-footer">
          
      <div class="container bottom">
            <span class="text-body-secondary"><ul class="nav justify-content-center border-bottom pb-3 mb-3">
            

          <li class='nav-item me-3'><a class='nav-link' href= "<?= base_url('/')?> ">Home</a></li>

            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Features</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Pricing</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">FAQs</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
          </ul>
          <p class="text-center text-body-secondary">© <a class="navbar-brand ps-1" href="#"><?php $config = config('App');
        echo $config->siteName;?></a> Inc. 2024 </p></span>
      </div>

          
  
</footer>
  
  
<script>
        const isLoggedIn = <?php echo json_encode($loggedIn); ?>;
    </script>


</body>

</html>

<script>
    // Function to set a cookie
    function setCookie(name, value, days) {
      const date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      const expires = "expires=" + date.toUTCString();
      document.cookie = name + "=" + value + ";" + expires + ";path=/";
    }

    // Function to get a cookie value
    function getCookie(name) {
      const cookieName = name + "=";
      const decodedCookie = decodeURIComponent(document.cookie);
      const cookieArray = decodedCookie.split(';');
      for (let i = 0; i < cookieArray.length; i++) {
        let cookie = cookieArray[i];
        while (cookie.charAt(0) === ' ') {
          cookie = cookie.substring(1);
        }
        if (cookie.indexOf(cookieName) === 0) {
          return cookie.substring(cookieName.length, cookie.length);
        }
      }
      return "";
    }

    // Function to toggle theme
    function toggleTheme() {
      if (!isLoggedIn) return; // Only allow theme toggle if logged in
      const currentTheme = document.documentElement.getAttribute('data-bs-theme');
      const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-bs-theme', newTheme);
      // Save theme preference to a cookie
      setCookie('theme', newTheme, 30);
    }

    // Apply theme preference from cookie on page load
    window.onload = function() {
      if (!isLoggedIn) return; // Only apply theme if logged in
      const savedTheme = getCookie('theme');
      if (savedTheme) {
        document.documentElement.setAttribute('data-bs-theme', savedTheme);
      }
    };

    // Event listener for theme toggle button
    const themeToggleBtn = document.getElementById('theme-toggle-btn');
    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', toggleTheme);
    }
    </script>