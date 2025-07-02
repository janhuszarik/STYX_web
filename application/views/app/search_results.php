<?php
// Pomocná funkcia na generovanie URL článku podľa slugu
if (!function_exists('get_article_url')) {
    function get_article_url($result) {
        if (!empty($result['slug'])) {
            return base_url() . $result['slug'];
        }
        // fallback – ak nemáš slug
        return '#';
    }
}
?>

<?php if (!empty($results) && is_array($results)): ?>
    <div class="search-results">
        <h2 class="mb-4">Suchergebnisse für "<?= htmlspecialchars($query) ?>"</h2>
        <div class="search-result-list">
            <?php foreach ($results as $result): ?>
                <div class="search-result-item mb-3 p-3 border rounded" style="background-color: #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">

                    <?php if ($result['type'] == 'article'): ?>
                        <h3 class="mb-1">
                            <a href="<?= htmlspecialchars(get_article_url($result)) ?>"
                               class="text-decoration-none text-primary" target="_blank">
                                <?= htmlspecialchars(trim($result['title']) ?: 'ID ' . $result['id']) ?>
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
                                <?= htmlspecialchars(trim($result['title']) ?: 'ID ' . $result['id']) ?>
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
                                <?= htmlspecialchars(trim($result['title']) ?: 'ID ' . $result['id']) ?>
                            </a>
                        </h3>
                        <small class="text-secondary">
                            <i class="fas fa-folder-open me-1"></i>
                            <?= $generate_path($result) ? $generate_path($result) : 'Unbekannter Pfad' ?>
                        </small>
                    <?php endif; ?>

                    <?php
                    $subtext = '';
                    if (!empty($result['content'])) {
                        $content = strip_tags($result['content']);
                        $pos = stripos($content, $query);
                        if ($pos !== false) {
                            $start = max(0, $pos - 20);
                            $subtext = '...' . substr($content, $start, 100) . '...';
                            $subtext = str_ireplace($query, '<strong>' . $query . '</strong>', $subtext);
                        }
                    } elseif ($result['type'] == 'article_category' || $result['type'] == 'neuigkeiten_subcategory') {
                        $subtext = $result['type'] == 'article_category' ? 'Hauptmenüpunkt' : 'Menüpunkt unter der Hauptkategorie';
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
