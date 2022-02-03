<script src="https://kit.fontawesome.com/723297a893.js" crossorigin="anonymous"></script>

<header>
    <nav>
        <div class="header-left">
            <?php /* @var Renderer $renderer*/
            use Controllers\Renderer;
            $renderer->getHeaderLinks(); ?>
        </div>

        <div class="header-mid">
            <span class="nav-item">HIITrainer</span>
        </div>

        <div class="header-right">
            <?php /* @var Renderer $renderer*/
            $renderer->getAuthButtons(); ?>
        </div>
    </nav>
</header>
