-- =============================================================
-- 6.19. Index létrehozása
-- =============================================================

-- Egyszerű index egy oszlopon
CREATE INDEX idx_email ON users(email);

-- Összetett index több oszlopon
CREATE INDEX idx_city_age ON users(city, age);

-- UNIQUE index egyedi értékek biztosítására
CREATE UNIQUE INDEX idx_username ON users(username);
