# doorweboffice1 작업 인수인계 (HANDOFF)

> 다른 PC에서 이어받을 때 이 파일을 Claude(Cowork)에게 먼저 읽혀라.
> 배포 zip(카페24 제출본)에는 이 파일·README·.gitignore 제외할 것.

## 현재 상태 (2026-07-04, v5.1.0)

- FSE 블록테마, theme.json v3, standalone, GPL v2+. 브랜드 Navy #0B1F3A / Gold #C8A24B
- AI/GEO 레이어 검증 완료: /llms.txt 200 (활성화 시 자동 flush 작동 확인), JSON-LD Organization/WebSite (SEO 플러그인 감지 시 자동 비활성)
- 푸터에 Doorweb 브랜드 크레딧 링크 (doorweb.net, 브랜드명 앵커만 — 키워드 앵커 금지)
- 기업 홈 패턴 8종 + 통합 패턴 `home-company` + 랜딩 템플릿 `page-landing`
- GitHub: https://github.com/doorweboffice/doorweboffice1 (개인 계정, Doorweb 조직 아님)

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

## 주의사항

- 홈이 720px로 좁게 나오면: 페이지 템플릿이 "랜딩"인지 확인. 템플릿의 main 그룹은 layout default(flow)여야 함 — constrained로 감싸면 post-content가 720에 갇힘 (v5.1.0에서 수정됨)
- 사이트 에디터에서 템플릿/패턴을 수정·저장하면 DB 버전이 파일을 덮음 — 파일 수정이 반영 안 되면 "사용자 정의 지우기"
- 스키마는 Rank Math/Yoast/AIOSEO/SEO Framework 설치 시 자동 꺼짐 — 버그 아님
