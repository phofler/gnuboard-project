<style>
/* 
 * [Premium Theme Protocol] Shared Typography Standards
 * 모든 스킨은 테마의 style.css에 정의된 변수를 상속받아야 함.
 */
.section-title {
    /* 테마 변수 상속 (style.css에서 정의됨) */
    color: var(--color-text-primary, #333);
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: var(--mc-title-size, 2.5rem);
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 2px;
    text-align: center;
    margin-bottom: 20px;
    display: block;
}

.section-subtitle {
    color: var(--color-text-secondary, #666);
    font-size: 1.1rem;
    font-weight: 300;
    margin-bottom: 40px;
    text-align: center;
}

/* 
 * Isolation Wrapper: 테마 스타일 간섭 방지 및 스코프 제한
 */
.mc-skin-wrapper {
    position: relative;
    width: 100%;
}

/* 공통 브랜드 강조색 유틸리티 */
.text-brand { color: var(--color-brand, var(--color-accent, #d4af37)); }
.bg-brand { background-color: var(--color-brand, var(--color-accent, #d4af37)); }
.border-brand { border-color: var(--color-brand, var(--color-accent, #d4af37)); }
</style>