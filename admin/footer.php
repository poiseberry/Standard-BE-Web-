  <footer>
    	<div class="row">
            	<div class="container">
                    <hr>

                    	<div class="row hidden-xs">
                        	<div class="col-md-3">
                                <h5>PRINCE2</h5>
                                <ul class="list-unstyled">
                                    <a href="http://prince2.com.my/what-is-prince2/"><li>What is PRINCE2?</li></a>
				    <a href="http://prince2.com.my/what-is-prince2/#what-is-prince2"><li>PRINCE2 Principles</li></a>
                                    <a href="http://prince2.com.my/what-is-prince2/#what-is-prince2"><li>PRINCE2 Themes</li></a>
                                    <a href="http://prince2.com.my/what-is-prince2/#what-is-prince2"><li>PRINCE2 Processes</li></a>
                                    <a href="http://prince2.com.my/pm-prince2-agile-training/">
                                        <li>PRINCE2 Agile</li>
                                    </a>
                                </ul>
                            </div><!--col-->

                            <div class="col-md-3">
                                 <h5>PRINCE2 Certification Exams</h5>
                                 <ul class="list-unstyled">
                                    <a href="http://prince2.com.my/project-management-certification/"><li>PRINCE2 Certification Exams</li></a>
                                    <a href="http://prince2.com.my/project-management-certification/#prince2-cert-exams"><li>Foundation Exam Structure</li></a>
                        				    <a href="http://prince2.com.my/project-management-certification/#prince2-cert-exams"><li>Practitioner Exam Structure</li></a>
                        				    <a href="http://prince2.com.my/project-management-certification/#prince2-cert-exams"><li>PRINCE2 Practitioner Re-registration</li></a>
                                    <a href="http://prince2.com.my/pm-prince2-agile-training/">
                                        <li>PRINCE2 Agile Practitioner Exam Structure</li>
                                    </a>
                                </ul>
                            </div><!--col-->

			    <div class="col-md-3 footer-dl">
                                 <h5>PRINCE2 Courses</h5>
                                 <ul class="list-unstyled">
                                    <a href="http://prince2.com.my/?ddownload=175"><li>PRINCE2 Foundation</li></a>
                                    <a href="http://prince2.com.my/?ddownload=176"><li>PRINCE2 Practitioner</li></a>
				    <a href="http://prince2.com.my/?ddownload=177"><li>PRINCE2 Overview</li></a>
				    <a href="http://prince2.com.my/?ddownload=178"><li>PRINCE2 Senior Management</li></a>
            <a href="http://prince2.com.my/?ddownload=836">
                <li>PRINCE2 Agile</li>
            </a>
                                </ul>
                            </div><!--col-->

                            <div class="col-md-3">
                                <ul class="list-unstyled">
                                    <a href="http://prince2.com.my/training-schedule.php">
                                        <li><h5>PRINCE2 Training Schedule</h5></li>
                                    </a>
                                    <a href="http://www.prince2.com.my/elearning-course-selection.php">
                                        <li><h5>E-Learning</h5></li>
                                    </a>
                                    <?php
                                    $queryCourseCats = "SELECT *  FROM " . $table['course_ecategory'] . " WHERE status=1 and site_id like '%3%' and pkid in (SELECT cat_pkid  FROM " . $table['course_elearning'] . " WHERE  status=1 and site_id like '%3%')  order by sortorder";
                                    $resultsCourseCats = $database->query($queryCourseCats);
                                    while ($results_courseCats = $resultsCourseCats->fetchRow()) {
                                        ?>
                                        <a href="http://prince2.com.my/<?= $results_courseCats['short_url'] ?>">
                                            <li><?= $results_courseCats['short_name'] ?></li>
                                        </a>
                                    <? } ?>
                                </ul>
                            </div><!--col-->
                        </div><!--row-->


                        <div class="row small">
                            	<div class="col-md-12">
                                <h6>HiLogic Sdn Bhd</h6>
                                </div>

                                <div class="col-md-2 col-xs-6">
                                    36th Floor, Menara Maxis<br>
                                    Kuala Lumpur City Centre <br>
                                    50088 Kuala Lumpur, Malaysia
                                </div><!--col-->


                                <div class="col-md-2 col-xs-6">
                                Tel	+603 2615 0081<br>
                                Fax	+603 2615 0088

                                </div><!--col-->
                        </div><!--row-->

                </div><!--container-->
        </div><!--row-->

    	<div class="row footerMini">
            	<div class="container container-wide">
                	<div class="col-md-4">
			<p>&copy;  prince2.com.my
</p>
                    </div><!--col-->

                    <div class="col-md-3 pull-right">
                        	<ol class="mini-menuFooter">
                              <!--<li><a href="#">sitemap</a></li>-->
                              <li><a href="http://prince2.com.my/terms-of-use/">Copyright & Trademarks</a></li>
                            </ol>
                    </div><!--col-->
                </div><!--container-->
        </div><!--row-->
    </footer>


  <script src="wp-content/themes/wpbootstrap/bootstrap/js/jquery.js"></script>
  <script src="wp-content/themes/wpbootstrap/bootstrap/js/bootstrap.js"></script>
  <script src="wp-content/themes/wpbootstrap/bootstrap/js/bootstrapValidator.js"></script>
  <script src="wp-content/themes/wpbootstrap/bootstrap/css/bootstrapValidator.css"></script>
  <script type="text/javascript" src="js/jquery.matchHeight.js"></script>
  <script>
  $('.carousel').carousel()
  $(function () {
      $('.overviewLearningHeight').matchHeight({});
      $('.overviewLearning').matchHeight();
  });
  </script>
  </body>
</html>
