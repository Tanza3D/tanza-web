<?php
$posts = Database::execSimpleSelect("SELECT * FROM Blog ORDER BY ReleaseDate DESC");
$random = $posts[random_int(0, count($posts)-1)];
?>
<div id="home">
    <div class="cover cover-small">
        <img src="https://raw.githubusercontent.com/Tanza3D/blog/main/<?= $random['InternalName'] ?>/cover.png">

        <h1>Blog</h1>
        <p>Blogposts about design, development, or other cool things
        <p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <div class="page-content" aload="basic" loadelement="window">
        <div class="page-inner">
            <?php
            $iterator = 0;
            foreach($posts as $post) {
                if($post['PostData'] == null) {
                    $post['PostData'] = file_get_contents("https://raw.githubusercontent.com/Tanza3D/blog/main/".$post['InternalName']."/index.md");
                    Database::execOperation("UPDATE `Blog` SET `PostData` = ? WHERE `InternalName` = ?", "ss", [$post['PostData'], $post['InternalName']]);
                }
                $post['PostData'] = str_replace("(assets/", "(https://raw.githubusercontent.com/Tanza3D/blog/main/".$post['InternalName']."/assets/", $post['PostData']);

                $posts[$iterator] = $post;

                $sentence = explode("\n", $post['PostData'])[0];
                ?>
                <a href="/blog?post=<?= $post['InternalName'] ?>" class="blogpost-item"
                    onclick="return openPost('<?= $post['InternalName'] ?>')">
                    <img src="https://raw.githubusercontent.com/Tanza3D/blog/main/<?= $post['InternalName'] ?>/cover.png">
                    <div>
                        <h1>
                            <?= $post['Name'] ?>
                        </h1>
                        <h3>
                            <?= $post['ReleaseDate'] ?>
                        </h3>
                        <p>
                            <?= nl2br(htmlentities($sentence)); ?>
                        </p>
                    </div>
                </a>
                <?php

                $iterator += 1;
            }
            ?>
        </div>
        <script>
            const postdata = <?= json_encode($posts) ?>;
        </script>
    </div>
</div>

<div id="post">
    <div class="goback" onclick="closePost()"><i class="fas fa-arrow-left"></i>Go Back</div>
    <img id="post-cover">
    <h1 id="post-title"></h1>
    <h3 id="post-date"></h3>
    <div id="post-content" class="markdown">

    </div>
</div>