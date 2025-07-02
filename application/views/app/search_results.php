<style>.search-results {
        max-width: 900px;
        margin: 40px auto 0 auto;
        padding: 0 10px;
    }

    .search-results h2 {
        font-size: 2.2rem;
        font-weight: 700;
        color: #222;
        margin-bottom: 32px;
        letter-spacing: -1px;
    }

    .search-result-list {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .search-result-item {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.07);
        padding: 28px 28px 16px 28px;
        transition: box-shadow 0.22s cubic-bezier(.4,0,.2,1), border-color 0.22s cubic-bezier(.4,0,.2,1);
        position: relative;
    }

    .search-result-item:hover {
        box-shadow: 0 4px 28px rgba(44, 170, 89, 0.11);
        border-color: #aadbb9;
    }

    .search-result-item h3 {
        font-size: 1.65rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #2baa59;
        line-height: 1.2;
    }

    .search-result-item h3 a {
        color: #2baa59;
        text-decoration: none;
        transition: color 0.16s;
    }
    .search-result-item h3 a:hover {
        color: #24704f;
        text-decoration: underline;
    }

    .search-result-item small {
        font-size: 0.97rem;
        color: #8e9aad;
        display: block;
        margin-bottom: 8px;
        letter-spacing: 0.02em;
        word-break: break-all;
    }

    .search-result-item .fa-globe,
    .search-result-item .fa-folder-open {
        color: #2baa59;
        margin-right: 4px;
        opacity: 0.84;
    }

    .search-result-item p {
        margin-bottom: 0;
        font-size: 1.03rem;
        color: #6b747e;
    }

    .search-result-item strong {
        color: #24704f;
        font-weight: 600;
        background: #e9ffe9;
        padding: 1px 4px;
        border-radius: 4px;
    }

    @media (max-width: 600px) {
        .search-result-item {
            padding: 18px 9px 12px 9px;
        }
        .search-results h2 {
            font-size: 1.45rem;
        }
        .search-result-item h3 {
            font-size: 1.15rem;
        }
    }
</style>

<?php
// Pomocná funkcia na generovanie URL článku podľa tvojej štruktúry
if (!function_exists('get_article_url')) {
    function get_article_url($result) {
        if (!empty($result['url'])) {
            return $result['url'];
        }
        if (!empty($result['slug'])) {
            return base_url() . $result['slug'];
        }
        return '#';
    }
}
?>

<?php if (!empty($results) && is_array($results)): ?>
    <div class="search-results">
        <h2 class="mb-4">Suchergebnisse für „<?= htmlspecialchars($query) ?>“</h2>
        <div class="search-result-list">
            <?php foreach ($results as $result): ?>
                <?php
                // Skry všetky neplatné/prázdne výsledky:
                if (
                    (in_array($result['type'], ['article', 'news']) && (empty($result['title']) || (isset($result['id']) && $result['id'] == 0)))
                    || ($result['type'] == 'article_section' && (empty($result['title']) || (isset($result['id']) && $result['id'] == 0)))
                    || (empty($result['title']))
                ) {
                    continue;
                }
                ?>
                <div class="search-result-item mb-3 p-3 border rounded" style="background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">

                    <?php if ($result['type'] == 'article'): ?>
                        <h3 class="mb-1">
                            <a href="<?= htmlspecialchars(get_article_url($result)) ?>"
                               class="text-decoration-none text-primary" target="_blank">
                                <?= htmlspecialchars(trim($result['title'])) ?>
                            </a>
                        </h3>
                        <small class="text-secondary d-block mt-1">
                            <i class="fas fa-globe me-1"></i>
                            <a href="<?= htmlspecialchars(get_article_url($result)) ?>" target="_blank">
                                <?= htmlspecialchars(get_article_url($result)) ?>
                            </a>
                        </small>
                    <?php elseif ($result['type'] == 'article_category'): ?>
                        <h3 class="mb-1">
                            <a href="<?= htmlspecialchars($result['url']) ?>"
                               class="text-decoration-none text-primary" target="_blank">
                                <?= htmlspecialchars(trim($result['title'])) ?>
                            </a>
                        </h3>
                        <small class="text-secondary d-block mt-1">
                            <i class="fas fa-globe me-1"></i>
                            <a href="<?= htmlspecialchars($result['url']) ?>" target="_blank"><?= htmlspecialchars($result['url']) ?></a>
                        </small>
                        <?php if (!empty($result['description'])): ?>
                            <p class="mb-1 text-muted small"><?= htmlspecialchars($result['description']) ?></p>
                        <?php endif; ?>
                    <?php else: ?>
                        <h3 class="mb-1">
                            <a href="<?= htmlspecialchars($result['url']) ?>"
                               class="text-decoration-none text-primary" target="_blank"
                                <?= empty($result['url']) || $result['url'] === '#' ? 'style="pointer-events: none; color: #6c757d;"' : '' ?>>
                                <?= htmlspecialchars(trim($result['title'])) ?>
                            </a>
                        </h3>
                        <small class="text-secondary">
                            <i class="fas fa-folder-open me-1"></i>
                            <?= $generate_path($result) ? $generate_path($result) : 'Unbekannter Pfad' ?>
                        </small>
                    <?php endif; ?>

                    <?php
                    // Ukážka popisu/podtextu (vždy aspoň description/meta/keywords)
                    $subtext = '';

                    // 1. Najprv zvýrazni vyhľadávané slovo v obsahu (ak je zhoda)
                    if (!empty($result['content'])) {
                        $content = strip_tags($result['content']);
                        $pos = stripos($content, $query);
                        if ($pos !== false) {
                            $start = max(0, $pos - 40);
                            $subtext = '...' . substr($content, $start, 160) . '...';
                            $subtext = str_ireplace($query, '<strong>' . $query . '</strong>', $subtext);
                        }
                    }

                    // 2. Ak ešte nie je subtext, vypíš vždy description alebo meta alebo keywords atď.
                    if (empty($subtext)) {
                        foreach (['description', 'meta', 'keywords', 'subtitle', 'text', 'content1'] as $field) {
                            if (!empty($result[$field])) {
                                $subtext = htmlspecialchars(strip_tags($result[$field]));
                                break;
                            }
                        }
                    }

                    // 3. Menu fallback (zachovaj)
                    if (empty($subtext) && ($result['type'] == 'article_category' || $result['type'] == 'neuigkeiten_subcategory')) {
                        $subtext = $result['type'] == 'article_category'
                            ? 'Hauptmenüpunkt'
                            : 'Menüpunkt unter der Hauptkategorie';
                    }
                    ?>
                    <?php if ($subtext): ?>
                        <p class="mb-1 text-muted small"><?= $subtext ?></p>
                    <?php else: ?>
                        <p class="mb-1 text-muted small">Keine relevante Beschreibung verfügbar</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <div class="search-results">
        <p class="text-center">Keine Ergebnisse gefunden.</p>
    </div>
<?php endif; ?>
