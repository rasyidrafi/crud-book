<style>
    @media (min-width: 992px) {
        .nav-link {
            color: white !important;
            text-transform: uppercase;
            border-right: solid 2px;
            margin-left: 15px;
        }
    }

    .nav-link {
        color: white !important;
        text-transform: uppercase;
    }

    .nav-link:hover {
        background-color: var(--bs-info);
        color: var(--bs-light) !important;
        border-color: var(--bs-info);
        border-radius: 5px;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="assets/icon.png" height="30px">
            <span class="fw-bold">Lamda Books</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav-collapse" aria-controls="nav-collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse flex-row-reverse text-center navbar-collapse" id="nav-collapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <span class="nav-link">Tanggal<br />
                        <span class="fw-bold"><?php echo date('m/d/Y', time()); ?></span>
                    </span>
                </li>
                <li class="nav-item">
                    <span class="nav-link">Kasir<br>
                        <span class="fw-bold"><?php echo "Rasyid" ?></span>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</nav>