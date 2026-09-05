@includeWhen(
    (!$hideTitle && !empty($postTitle)) || !empty($titleCTA),
    'partials.post-title',
    ['titleCTA' => $titleCTA ?? null]
)
@includeWhen($preamble, 'partials.preamble')

@if (!empty($mixedCards) || !empty($mixedList))
  <div
    class="modularity-posts-extensions-mixed{{ !empty($preamble) || (!$hideTitle && !empty($postTitle)) ? ' u-margin__top--4' : '' }}"
  >
    @foreach ($mixedCards as $post)
      <div class="modularity-posts-extensions-mixed__card">
        @include('partials.post.card')
      </div>
    @endforeach

    @if (!empty($mixedList))
      <div class="modularity-posts-extensions-mixed__list">
        @card([
            'heading' => false,
            'context' => 'module.posts.list',
        ])
          @collection([
              'sharpTop' => false,
              'bordered' => false,
          ])
            @foreach ($mixedList as $post)
              @if ($post->getPermalink() && $post->getTitle())
                @collection__item([
                    'icon' => $post->icon,
                    'link' => $post->getPermalink(),
                    'attributeList' => array_merge($post->attributeList ?? [], [
                        'aria-labelledby' => 'post-' . $ID . '-' . $post->getId() . '-title',
                    ]),
                    'classList' => $post->classList ?? [],
                ])
                  @typography([
                      'element' => 'h2',
                      'variant' => 'h4',
                      'id' => 'post-' . $ID . '-' . $post->getId() . '-title',
                  ])
                    {!! $post->getTitle() !!}
                  @endtypography
                @endcollection__item
              @endif
            @endforeach
          @endcollection
        @endcard
      </div>
    @endif
  </div>
@endif

@include('partials.more')
