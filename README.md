# doorweboffice1

AI/GEO 최적화 독립 블록 테마(FSE). 빌더 의존 없음.

## 왜 이 테마인가 (셀링/인지도 포인트)
2026년 검색은 구글 SERP + AI 답변(ChatGPT/Perplexity/네이버 큐:)로 갈라졌다.
이 테마는 **AI가 사이트를 정확히 읽고 인용하도록** 구조를 처음부터 설계했다.

## 내장된 AI/GEO 기능
- **JSON-LD 스키마 자동 출력**: Organization / WebSite(+SearchAction) / WebPage.
  - Rank Math·Yoast·AIOSEO·SEO Framework 감지 시 **자동 비활성**(스키마 중복 방지).
  - 강제 제어: `add_filter('doorweboffice1_enable_schema', '__return_false');`
- **llms.txt 자동 서빙** (`/llms.txt`): LLM 크롤러용 사이트 요약·핵심 링크.
  - 운영 시 회사 소개/핵심 페이지로 반드시 커스텀할 것.
- **시맨틱 HTML5 구조**: 블록 템플릿이 `<header><main><footer>` 랜드마크로 출력.
- **빌더 의존 제로**: 워프 기본 블록 에디터로 편집. Elementor/Astra 불필요.

## 스택
- FSE(Full Site Editing) 블록 테마, `theme.json` v3
- 부모테마 없음(standalone), GPL v2+
- 브랜드 토큰: Navy `#0B1F3A` / Gold `#C8A24B`

## 구조
```
style.css        테마 헤더
theme.json       디자인 토큰·레이아웃·설정
functions.php    support + AI/GEO 레이어(스키마·llms.txt)
templates/       index·single·page·archive·404
parts/           header·footer
patterns/        hero (Navy/Gold)
```

## 재사용 (크몽·클라이언트)
- 이 테마를 베이스로 얹고 → 블록 패턴/theme.json 색만 바꿔 클라이언트별 변주.
- Elementor 레이아웃과 달리 **디자인이 파일(코드)에 남아** git으로 두 머신·프로젝트 간 공유됨.

## 두 머신 워크플로우
앉으면 `git pull`, 뜨기 전 `git add . && git commit -m "..." && git push`. 브랜치 나누지 말 것.

## TODO (판매/등록 전)
- [ ] screenshot.png (1200×900) 추가 — 관리자 테마 목록 썸네일
- [ ] llms.txt 내용 실제 회사 정보로 커스텀
- [ ] `Theme Check` 플러그인으로 통과 확인
- [ ] 데모 콘텐츠 1세트 (카페24 상세페이지·크몽 포트폴리오용 스크린샷)
