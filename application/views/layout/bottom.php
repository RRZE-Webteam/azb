</div>

			<footer id="colophon" class="site-footer clear" role="contentinfo">

				<nav id="tech-navigation" class="tech-navigation clear" role="navigation">
					<ul id="menu-tech-menue" class="tech-menu">
            <?php if($this->lib_session->isInitialized()) : ?>
            <li class="logout">
              <a href="<?php echo base_url(); ?>logout">
                <span class="glyphicon glyphicon-off"> </span>
                Ausloggen
              </a>
            </li>
            <?php endif; ?>
						<li><a href="<?php echo base_url(); ?>page">Start</a></li>
						<li><a href="<?php echo base_url(); ?>page/hilfe">Hilfe</a></li>
						<li><a href="<?php echo base_url(); ?>page/fragen_und_antworten">Fragen &amp; Antworten</a></li>
						<li><a href="<?php echo base_url(); ?>page/impressum">Impressum</a></li>
						<li><a href="<?php echo base_url(); ?>page/kontakt">Kontakt</a></li>
					</ul>
				</nav><!-- .tech-navigation -->

				<div id="footer-1" class="footer-1" role="complementary">
					<aside>
            <div class="links">
              <h2>Links</h2>
              <ul>
                <li><a href="http://www.fau.de" target="_blank">FAU</a></li>
                <li><a href="http://www.rrze.fau.de">RRZE</a></li>
                <li><a href="http://www.rrze.fau.de/ausbildung/berufsausbildung/">Berufsausbildung am RRZE</a></li>
              </ul>
            </div>
					</aside>

					<aside id="footer-logo-container">
            <img src="<?= base_url(); ?>assets/img/logo_fau.png" class="footer-logo"/>
					</aside>
				</div><!-- #footer-1 -->

			</footer><!-- .site-footer -->
		</div>
	</body>
</html>
