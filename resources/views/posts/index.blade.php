<x-layouts.main>

    <!-- Page Header Start -->
    <x-page-header>
        Blog
    </x-page-header>
    <!-- Page Header End -->


    <!-- Blog Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row align-items-end mb-4">
                <div class="col-lg-6">
                    <h6 class="text-secondary font-weight-semi-bold text-uppercase mb-3">Latest Blog</h6>
                    <h1 class="section-title mb-3">Songi postlar</h1>
                </div>

            </div>
            <div class="row">
                <?php foreach ($posts as $post) { ?>
                    <div class="col-lg-4 col-md-6 mb-5">
                        <div class="position-relative mb-4">
                            <img class="img-fluid rounded w-50" src="storage/<?= $post->photo ?>" alt="">
                            <div class="blog-date">
                                <h4 class="font-weight-bold mb-n1"><?= $post->created_at->format('d') ?></h4>
                                <small class="text-white text-uppercase"><?= $post->created_at->format('M') ?></small>
                            </div>
                        </div>
                        <div class="d-flex mb-2">
                            @foreach ($post->tags as $tag )
                            <a class="text-secondary text-uppercase font-weight-medium" href="">{{ $tag->name }}</a>
                            <span class="text-primary px-2">|</span> 
                            @endforeach
                            
                        </div>
                        <div class="d-flex mb-2">
                            <a class="text-danger text-uppercase font-weight-medium">{{ $post->category->name ?? 'Unknown Category'}}</a>
                            
                        </div>
                        <h5 class="font-weight-medium mb-2"><?= $post->title ?></h5>
                        <p class="mb-4"><?= $post->short_content ?></p>
                        <a class="btn btn-sm btn-primary py-2" href="{{ route('posts.show', ['post' => $post->id ]) }}">Read More</a>
                    </div>
                <?php } ?>

                {{ $posts->links() }}


            </div>
        </div>
    </div>
    <!-- Blog End -->

</x-layouts.main>