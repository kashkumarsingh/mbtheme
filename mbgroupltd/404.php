<?php get_header(); ?>

<div class="container-fluid min-h-screen bg-gray-100 flex items-center justify-center">
    <section class="text-center py-16">
        <h1 class="text-4xl md:text-5xl lg:text-6xl mb-4 font-semibold">404 Error</h1>
        <p class="mb-4 text-base md:text-lg font-medium">Oops, it looks like the page cannot be found.</p>
        <a class="btn btn-danger btn-lg" href="<?php echo home_url(); ?>">Go back to the homepage</a>
    </section>
</div>

<?php get_footer(); ?>
