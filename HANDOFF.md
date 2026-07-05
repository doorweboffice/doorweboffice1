# doorweboffice1 작업 인수인계 (HANDOFF)

> 다른 PC에서 이어받을 때 이 파일을 Claude(Cowork)에게 먼저 읽혀라.
> 배포 zip(카페24 제출본)에는 이 파일·README·.gitignore 제외할 것.

## 현재 상태 (2026-07-04, v5.2.0)

- FSE 블록테마, theme.json v3, standalone, GPL v2+. 브랜드 Navy #0B1F3A / Gold #C8A24B
- AI/GEO 레이어 검증 완료: /llms.txt 200 (활성화 시 자동 flush 작동 확인), JSON-LD Organization/WebSite (SEO 플러그인 감지 시 자동 비활성)
- 푸터에 Doorweb 브랜드 크레딧 링크 (doorweb.net, 브랜드명 앵커만 — 키워드 앵커 금지)
- 기업 홈 패턴 8종 + 통합 패턴 `home-company` + 랜딩 템플릿 `page-landing`
- 히어로 슬라이더 패턴 `hero-slider` (4장): 한방향 무한루프(첫 장 JS 복제), 5초 자동재생, 골드 도트, scroll-snap, slider.js 약 2KB defer. 슬라이드 = 일반 커버 블록(복제로 추가, 삭제로 축소). 텍스트는 alignwide(1200px) 그룹으로 본문 라인 정렬
- 간격 제거 CSS: .wp-site-blocks 직계 + main 직계 + post-content 직계 margin 0 (섹션 내부 문단 간격은 유지 — 전체 0 금지, 텍스트 뭉개짐)
- 에디터 전용 editor.css: 슬라이더 트랙 세로 펼침(편집용)
- GitHub: https://github.com/doorweboffice/doorweboffice1 (개인 계정, Doorweb 조직 아님)
- 렌더 확인 현황: 슬라이더 작동·풀와이드·도트 확인됨(스샷). 텍스트 폭 정렬(재삽입 후)과 섹션 간격 제거는 최종 스샷 미확인 — 사무실에서 첫 작업으로 확인할 것
- WP 패턴 캐시 주의: 패턴 파일 추가 시 테마 버전 bump 해야 삽입기에 나타남 (WP 6.6+ 캐시)

## 메인페이지 방식 (확정)

페이지 생성 → 템플릿 "랜딩(제목·여백 없음)" 선택 → 패턴 "회사 홈 전체" 삽입 → 설정→읽기에서 정적 홈 지정.
Customizer(사용자 정의)는 FSE에서 미지원이며 의도적으로 배제. 온보딩 개선은 활성화 시 홈 자동 생성(starter content)으로 갈 것 — v5.2.0 후보.

## 다른 PC 셋업 순서

1. Local by WP Engine 설치, 사이트 생성 (예: office1)
2. `cd <site>/app/public/wp-content/themes` → `git clone https://github.com/doorweboffice/doorweboffice1.git`
3. WP 관리자에서 테마 활성화 → /llms.txt 200 확인
4. 작업 후 commit·push, 집 PC에서는 `git pull`

## 남은 TODO (카페24 등록 전)

- [ ] screenshot.png 1200×900 (테마 목록 썸네일이 현재 빈 체커보드)
- [ ] Theme Check 플러그인 통과 확인 (아직 미실행)
- [ ] `Tested up to: 6.7` 최신 WP 버전으로 갱신
- [ ] llms.txt 본문 실제 회사정보 커스텀
- [ ] 데모 콘텐츠 1세트 (상세페이지·포트폴리오 스크린샷용) — "30분 셋업" 과정 스크린샷 확보
- [ ] 카페24 심사 규정에서 타 채널(GitHub) 무료 배포 배타성 조항 여부 확인
- [ ] 배포 zip 패키징: HANDOFF.md/README.md/.gitignore 제외
- [ ] 사용자 매뉴얼 제작 (구매자용 설정 가이드 — 홈 구성, 슬라이더 편집, 이미지 교체 등. 전체 작업 완료 후 진행 예정)

## 광고 문구 골격 (상세페이지·README용)

층위 구분이 핵심: ① FSE = WP 공식 로드맵("몇 년 뒤에도 유효한 스택") ② 검증된 유리함 = 빌더 대비 깨끗한 시맨틱 HTML + 가벼운 출력 → Core Web Vitals 우수(실제 랭킹 요소) + JSON-LD 자동 + 시맨틱 랜드마크 ③ llms.txt = 신흥 표준 선점 베팅("보장" 아닌 "선점"으로 표현) ④ 30분 셋업, 빌더·플러그인 의존 제로. FSE 자체가 랭킹 요소라고 쓰지 말 것 — 유리함은 결과물 품질에서 온다는 논리 유지.

## 주의사항

- 홈이 720px로 좁게 나오면: 페이지 템플릿이 "랜딩"인지 확인. 템플릿의 main 그룹은 layout default(flow)여야 함 — constrained로 감싸면 post-content가 720에 갇힘 (v5.1.0에서 수정됨)
- 사이트 에디터에서 템플릿/패턴을 수정·저장하면 DB 버전이 파일을 덮음 — 파일 수정이 반영 안 되면 "사용자 정의 지우기"
- 스키마는 Rank Math/Yoast/AIOSEO/SEO Framework 설치 시 자동 꺼짐 — 버그 아님
