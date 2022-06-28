<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-5">
        <page-name :mainMenu="main" />
        <table-loading v-if="tableLoading" />
        <div class="row gx-4 mb-3" id="top">
          <div class="col-2">
            <h5 class="fw-bold my-3">콘텐츠 타입</h5>
            <select
              v-model="selected"
              class="form-select m-0 mb-1 w-100"
              @change="selectOption(selected)"
            >
              <option v-for="(contents, i) in contents" :key="i" :value="i + 1">
                {{ contents.CONTENTS_TYPE_NAME }}
              </option>
            </select>

            <div class="card">
              <ul class="list-group list-group-flush overflow-auto h-100">
                <li
                  class="list-group-item"
                  v-for="(contents, i) in contents"
                  :key="i"
                  :class="[{ active: i === activeContents }, { hover: hover }]"
                  @click="selectContentsType(i, contents)"
                  @mouseenter="hoverType(contents.CONTENTS_TYPE_NAME)"
                >
                  {{ contents.CONTENTS_TYPE_NAME }}
                </li>
              </ul>
            </div>
          </div>

          <div class="col-2">
            <h5 class="fw-bold my-3">리스트 방식</h5>
            <div class="card p-3">
              <div class="form-check mb-3">
                <input
                  class="form-check-input"
                  type="radio"
                  value="1"
                  id="flexCheckDefault"
                  v-model="listCheck"
                  @change="getTheme()"
                  @click="
                    activeContents = false;
                    contentsListShow = false;
                  "
                />
                <label class="form-check-label" for="flexCheckDefault">
                  API 기준
                </label>
              </div>
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="radio"
                  value="2"
                  id="flexCheckChecked"
                  v-model="listCheck"
                  @change="getTheme()"
                  @click="
                    activeContents = false;
                    contentsListShow = false;
                  "
                />
                <label class="form-check-label" for="flexCheckChecked">
                  자체 설정
                </label>
              </div>
            </div>
            <div class="alert alert-danger my-3" role="alert" v-if="warnning">
              API 기준에서 선택할 수 없습니다.
            </div>
          </div>

          <div class="col-8">
            <div class="d-flex align-items-center justify-content-between">
              <h5 class="fw-bold my-3">테마 리스트</h5>
              <div class="btn-group">
                <button
                  type="button"
                  class="btn btn-primary dropdown-toggle"
                  data-bs-toggle="dropdown"
                  data-bs-auto-close="true"
                >
                  + 테마 추가
                </button>
                <ul class="dropdown-menu p-3" style="width: 300px">
                  <li class="mb-3">
                    <input
                      class="form-control"
                      :class="[
                        { 'is-invalid': themeName === '' },
                        { 'is-invalid': activeContents === false },
                      ]"
                      type="text"
                      v-model="themeName"
                    />
                    <div
                      v-if="activeContents === false"
                      class="invalid-feedback"
                    >
                      콘텐츠 타입을 선택하세요.
                    </div>
                    <div v-if="themeName === ''" class="invalid-feedback">
                      테마 제목을 입력하세요.
                    </div>
                  </li>
                  <li class="d-flex justify-content-center">
                    <button
                      type="button"
                      class="btn btn-secondary me-3"
                      @click="themeName = ''"
                    >
                      취소
                    </button>
                    <button
                      type="button"
                      class="btn btn-primary"
                      @click="addTheme(), (themeName = '')"
                    >
                      등록
                    </button>
                  </li>
                </ul>
              </div>
            </div>
            <div class="card justify-content-between" id="theme">
              <ul class="list-group list-group-flush overflow-auto">
                <li class="list-group-item" v-if="noTheme">
                  <h6>테마를 추가하세요.</h6>
                </li>
                <li
                  v-for="(themeList, i) in themeList"
                  :key="i"
                  :class="{ active: i === activeThemeList }"
                  @click="
                    selectThemeList(i, themeList);
                    getContentsList();
                  "
                  class="list-group-item d-flex justify-content-between align-items-center hover"
                >
                  {{ themeList.THEME_NAME }}
                  <div class="d-flex">
                    <span
                      role="button"
                      class="material-symbols-rounded"
                      @click.stop="deleteTheme(themeList.SEQ_ID)"
                    >
                      delete
                    </span>
                    <span
                      role="button"
                      class="material-symbols-rounded"
                      @click.stop="
                        upCurrentTheme(i);
                        orderTheme();
                      "
                    >
                      arrow_upward
                    </span>
                    <span
                      role="button"
                      class="material-symbols-rounded"
                      @click.stop="
                        downCurrentTheme(i);
                        orderTheme();
                      "
                    >
                      arrow_downward
                    </span>
                  </div>
                </li>
              </ul>
              <div
                @click="
                  getCurrentPage();
                  activeThemeList = false;
                "
              >
                <v-pagination
                  v-model="currentPage"
                  :page-count="totalPages"
                  :classes="bootstrapPaginationClasses"
                  :labels="paginationAnchorTexts"
                ></v-pagination>
              </div>
            </div>
          </div>
        </div>

        <div
          id="bottom"
          class="d-flex flex-column position-relative"
          v-if="contentsListShow"
        >
          <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-bold my-3">콘텐츠 리스트</h5>
            <button
              type="button"
              class="btn btn-primary"
              data-bs-toggle="modal"
              data-bs-target="#staticBackdrop"
              @click="
                getSizeCategory();
                thumbPathFormat();
                contentsName = '';
                keyword = '';
                thumbnail = null;
                editContents = false;
                colors = [];
                rgb = [];
              "
            >
              + 콘텐츠 추가
            </button>
          </div>
          <div class="card px-3 flex-row flex-wrap overflow-auto h-100">
            <div
              class="d-flex flex-column m-2"
              v-for="(contentsList, i) in contentsList"
              :key="i"
            >
              <div class="form-check form-check-inline">
                <input
                  class="form-check-input"
                  type="checkbox"
                  :value="contentsList.SEQ_ID"
                  v-model="useContents"
                  @click="contentsListCheck($event)"
                />
                <span
                  class="material-symbols-rounded me-1"
                  role="button"
                  @click="deleteContents(contentsList)"
                >
                  delete
                </span>
                <span
                  class="material-symbols-rounded"
                  role="button"
                  data-bs-toggle="modal"
                  data-bs-target="#editModal"
                  @click="
                    selectContentsList(contentsList);
                    oldThumbFile(contentsList);
                    oldContentsFile(contentsList);
                    getSizeCategory();
                    thumbPathFormat(contentsList.SEQ_ID);
                  "
                >
                  edit_note
                </span>
              </div>
              <!-- <img
                :src="contentsList.THUMB_PATH"
                class="img-thumbnail"
                style="width: 150px; height: 150px"
                alt=""
              /> -->
              <!-- 로컬서버 -->
              <img
                :src="local + contentsList.THUMB_PATH"
                class="img-thumbnail"
                style="width: 150px; height: 150px"
                alt=""
              />
            </div>
          </div>
          <button
            type="button"
            class="btn btn-secondary text-center btn-lg my-3 mx-auto"
            style="width: 200px"
            @click="contentsUseUnused()"
          >
            저 장
          </button>
        </div>

        <!-- 콘텐츠 추가 -->
        <div
          class="modal fade"
          id="staticBackdrop"
          data-bs-backdrop="static"
          data-bs-keyboard="false"
        >
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                  콘텐츠 추가 - {{ currentContents.CONTENTS_TYPE_NAME }}
                </h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body pe-5 py-3">
                <div class="mb-3 row">
                  <label for="conname" class="col-2 col-form-label fw-bold ps-5"
                    >콘텐츠 이름</label
                  >
                  <div class="col-10 position-relative">
                    <input
                      type="text"
                      class="form-control"
                      id="conname"
                      :class="{ 'is-invalid': invalidContentsName }"
                      v-model="contentsName"
                      @change="
                        contentsName !== ''
                          ? (invalidContentsName = false)
                          : (invalidContentsName = true)
                      "
                    />
                    <div
                      class="invalid-tooltip"
                      :class="[
                        { 'd-block': invalidContentsName },
                        { 'd-none': contentsName !== '' },
                      ]"
                    >
                      콘텐츠 이름을 입력하세요.
                    </div>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="contype" class="col-2 col-form-label fw-bold ps-5"
                    >콘텐츠 타입</label
                  >
                  <div class="col-10">
                    <input
                      type="text"
                      class="form-control"
                      id="contype"
                      readonly
                      :value="currentContents.CONTENTS_TYPE_NAME"
                    />
                  </div>
                </div>
                <div class="mb-3 row">
                  <label
                    for="contheme"
                    class="col-2 col-form-label fw-bold ps-5"
                    >콘텐츠 테마</label
                  >
                  <div class="col-10">
                    <input
                      type="text"
                      class="form-control"
                      id="contheme"
                      readonly
                      :value="currentThemeList.THEME_NAME"
                    />
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="keyword" class="col-2 col-form-label fw-bold ps-5"
                    >키워드</label
                  >
                  <div class="col-10 position-relative">
                    <input
                      type="text"
                      class="form-control"
                      id="keyword"
                      :class="{ 'is-invalid': invalidKeyword }"
                      v-model="keyword"
                      @change="
                        keyword !== ''
                          ? (invalidKeyword = false)
                          : (invalidKeyword = true)
                      "
                    />
                    <div
                      class="invalid-tooltip"
                      :class="[
                        { 'd-block': invalidKeyword },
                        { 'd-none': keyword !== '' },
                      ]"
                    >
                      키워드를 입력하세요.
                    </div>
                  </div>
                </div>
                <div class="mb-3 row">
                  <div class="col-2 col-form-label fw-bold ps-5">썸네일</div>
                  <div class="col-5">
                    <div class="row flex-column">
                      <img
                        :src="thumbnail"
                        id="thumbnail"
                        :class="{ thumbnail: thumbnail != null }"
                        class="p-0 mb-2 m-auto"
                        alt=""
                        v-if="thumbnail != null ? true : false"
                      />
                      <div class="input-group">
                        <input
                          type="file"
                          class="form-control"
                          id="thumbFile"
                          accept="image/*"
                          :class="{ 'is-invalid': invalidThumbnail }"
                          @change="
                            thumbFileSelect($event);
                            invalidThumbnail = false;
                          "
                        />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mb-3" v-if="!rgbShow">
                  <div class="col-2 col-form-label fw-bold ps-5">콘텐츠</div>
                  <div class="col-10">
                    <div class="row">
                      <div class="input-group w-50">
                        <input
                          type="file"
                          class="form-control"
                          id="contentsFile"
                          accept=".json, .woff"
                          :class="{ 'is-invalid': invalidContents }"
                          @change="
                            contentsFileSelect($event);
                            invalidContents = false;
                          "
                        />
                      </div>
                    </div>
                  </div>
                </div>
                <!-- 업로드 -->
                <div class="row mb-3" v-if="rgbShow">
                  <div class="col-2 col-form-label fw-bold ps-5">RGB</div>
                  <div class="col-10">
                    <color-picker
                      v-for="(colors, i) in colors"
                      :key="i"
                      :index="i"
                      @index="rgbFindIndex"
                      @input="changeColor"
                      @delete="deleteColor"
                    ></color-picker>
                    <button
                      type="button"
                      class="btn btn-primary mt-2"
                      @click="addColor()"
                    >
                      + 추가
                    </button>
                  </div>
                </div>
                <div class="row align-items-center mb-3">
                  <div class="col-2 col-form-label fw-bold ps-5">
                    콘텐츠 용도
                  </div>
                  <div class="col-10 position-relative">
                    <div class="form-check form-check-inline col-form-label">
                      <input
                        class="form-check-input"
                        type="radio"
                        id="useWeb"
                        value="web"
                        v-model="typeCheck"
                      />
                      <label class="form-check-label" for="useWeb">웹용</label>
                    </div>
                    <div class="form-check form-check-inline col-form-label">
                      <input
                        class="form-check-input"
                        type="radio"
                        id="usePrint"
                        value="print"
                        v-model="typeCheck"
                      />
                      <label class="form-check-label" for="usePrint"
                        >인쇄용</label
                      >
                    </div>
                  </div>
                </div>
                <div class="row mb-3" v-if="workingSizeShow">
                  <div class="col-2 col-form-label fw-bold ps-5">작업크기</div>
                  <div class="col-10">
                    <div class="row">
                      <div class="col">
                        <select
                          class="form-select me-3"
                          v-model="selectWorkingSize"
                          @change="getSize()"
                        >
                          <option
                            :value="i"
                            v-for="(sizeCategory, i) in sizeCategory"
                            :key="i"
                          >
                            {{ sizeCategory.TEMPLATE_TYPE_NAME }}
                          </option>
                        </select>
                        <select
                          class="form-select"
                          v-model="selectSize"
                          @change="getSize()"
                        >
                          <option :value="i" v-for="(size, i) in size" :key="i">
                            {{ size.SIZE_NAME }}
                          </option>
                        </select>
                      </div>
                      <div class="col">
                        <div class="row">
                          <div class="col">
                            <p>가로</p>
                            <input
                              type="text"
                              class="form-control"
                              v-model="width"
                              readonly
                            />
                          </div>
                          <div class="col">
                            <p>세로</p>
                            <input
                              type="text"
                              class="form-control"
                              v-model="height"
                              readonly
                            />
                          </div>
                          <div class="col">
                            <p>단위</p>
                            <input
                              type="text"
                              class="form-control"
                              v-model="scale"
                              readonly
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row align-items-center mb-3">
                  <div class="col-2 col-form-label fw-bold ps-5">사용여부</div>
                  <div class="col-10 position-relative">
                    <div class="form-check form-check-inline col-form-label">
                      <input
                        class="form-check-input"
                        type="radio"
                        id="publicTrue"
                        value="true"
                        v-model="publicFlage"
                      />
                      <label class="form-check-label" for="publicTrue"
                        >사용</label
                      >
                    </div>
                    <div class="form-check form-check-inline col-form-label">
                      <input
                        class="form-check-input"
                        type="radio"
                        id="publicFalse"
                        value="false"
                        v-model="publicFlage"
                      />
                      <label class="form-check-label" for="publicFalse"
                        >미사용</label
                      >
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-lg btn-primary m-auto"
                  @click="contentsUpload()"
                >
                  업로드
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- 콘텐츠 수정 -->
        <div
          class="modal fade"
          id="editModal"
          data-bs-backdrop="static"
          data-bs-keyboard="false"
        >
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editModalTitle">
                  콘텐츠 수정 - {{ currentContents.CONTENTS_TYPE_NAME }}
                </h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body pe-5 py-3">
                <div class="mb-3 row">
                  <label for="conname" class="col-2 col-form-label fw-bold ps-5"
                    >콘텐츠 이름</label
                  >
                  <div class="col-10 position-relative">
                    <input
                      type="text"
                      class="form-control"
                      id="conname"
                      :class="{ 'is-invalid': invalidContentsName }"
                      v-model="contentsName"
                      @change="
                        contentsName !== ''
                          ? (invalidContentsName = false)
                          : (invalidContentsName = true)
                      "
                    />
                    <div
                      class="invalid-tooltip"
                      :class="[
                        { 'd-block': invalidContentsName },
                        { 'd-none': contentsName !== '' },
                      ]"
                    >
                      콘텐츠 이름을 입력하세요.
                    </div>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="contype" class="col-2 col-form-label fw-bold ps-5"
                    >콘텐츠 타입</label
                  >
                  <div class="col-10">
                    <input
                      type="text"
                      class="form-control"
                      id="contype"
                      readonly
                      :value="currentContents.CONTENTS_TYPE_NAME"
                    />
                  </div>
                </div>
                <div class="mb-3 row">
                  <label
                    for="contheme"
                    class="col-2 col-form-label fw-bold ps-5"
                    >콘텐츠 테마</label
                  >
                  <div class="col-10">
                    <input
                      type="text"
                      class="form-control"
                      id="contheme"
                      readonly
                      :value="currentThemeList.THEME_NAME"
                    />
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="keyword" class="col-2 col-form-label fw-bold ps-5"
                    >키워드</label
                  >
                  <div class="col-10 position-relative">
                    <input
                      type="text"
                      class="form-control"
                      id="keyword"
                      :class="{ 'is-invalid': invalidKeyword }"
                      v-model="keyword"
                      @change="
                        keyword !== ''
                          ? (invalidKeyword = false)
                          : (invalidKeyword = true)
                      "
                    />
                    <div
                      class="invalid-tooltip"
                      :class="[
                        { 'd-block': invalidKeyword },
                        { 'd-none': keyword !== '' },
                      ]"
                    >
                      키워드를 입력하세요.
                    </div>
                  </div>
                </div>
                <div class="mb-3 row">
                  <div class="col-2 col-form-label fw-bold ps-5">썸네일</div>
                  <div class="col-4">
                    <div class="row flex-column">
                      <img
                        :src="thumbnail"
                        :class="{ thumbnail: thumbnail != null }"
                        class="p-0 mb-2 m-auto"
                        alt=""
                        v-if="thumbnail != null ? true : false"
                      />
                      <div class="input-group w-100">
                        <input
                          type="file"
                          class="form-control"
                          id="thumbFileEdit"
                          accept="image/*"
                          :class="{ 'is-invalid': invalidThumbnail }"
                          @change="
                            thumbFileSelect($event);
                            invalidThumbnail = false;
                          "
                        />
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <ul class="list-group" id="oldThumb">
                      <li class="list-group-item" v-if="oldThumb.length != 0">
                        이전 썸네일
                      </li>
                      <li class="list-group-item" v-if="oldThumb.length == 0">
                        No other files
                      </li>
                      <li
                        class="list-group-item"
                        v-for="(oldThumb, i) in oldThumb"
                        :key="i"
                      >
                        <div
                          class="row justify-content-center align-items-center"
                        >
                          <div class="col">
                            <img :src="oldThumb" class="thumbnail" alt="" />
                          </div>
                          <div class="col thumbnail position-relative">
                            <p class="fw-bold text-center">파일 삭제</p>
                            <span
                              class="material-symbols-rounded icon-size"
                              role="button"
                              @click="deleteOldThumb(oldThumb)"
                            >
                              delete_forever
                            </span>
                          </div>
                          <div class="col thumbnail position-relative">
                            <p class="fw-bold text-center">썸네일 변경</p>
                            <span
                              class="material-symbols-rounded icon-size"
                              role="button"
                              data-bs-dismiss="modal"
                              @click="changeThumb(oldThumb)"
                            >
                              published_with_changes
                            </span>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="row mb-3" v-if="!rgbShow">
                  <div class="col-2 col-form-label fw-bold ps-5">콘텐츠</div>
                  <div class="col-4">
                    <div class="row flex-column">
                      <div class="mb-2">
                        현재 파일:
                        {{
                          contentsFileFormat(currentContentsList.CONTENTS_PATH)
                        }}
                      </div>
                      <div class="input-group w-100">
                        <input
                          type="file"
                          class="form-control"
                          id="contentsFileEdit"
                          accept=".json"
                          :class="{ 'is-invalid': invalidContents }"
                          @change="
                            contentsFileSelect($event);
                            invalidContents = false;
                          "
                        />
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <ul class="list-group" id="oldContents">
                      <li
                        class="list-group-item"
                        v-if="oldContents.length != 0"
                      >
                        이전 콘텐츠
                      </li>
                      <li
                        class="list-group-item"
                        v-if="oldContents.length == 0"
                      >
                        No other files
                      </li>
                      <li
                        class="list-group-item"
                        v-for="(oldContents, i) in oldContents"
                        :key="i"
                      >
                        <div
                          class="row justify-content-center align-items-center"
                        >
                          <div class="col">
                            {{ oldContents }}
                          </div>
                          <div class="col oldIcon position-relative">
                            <p class="fw-bold text-center">파일 삭제</p>
                            <span
                              class="material-symbols-rounded icon-size fs-3"
                              role="button"
                              @click="deleteOldContents(oldContents)"
                            >
                              delete_forever
                            </span>
                          </div>
                          <div class="col oldIcon position-relative">
                            <p class="fw-bold text-center">콘텐츠 변경</p>
                            <span
                              class="material-symbols-rounded icon-size fs-3"
                              role="button"
                              data-bs-dismiss="modal"
                              @click="changeContents(oldContents)"
                            >
                              published_with_changes
                            </span>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
                <!-- 수정 -->
                <div class="row mb-3" v-if="rgbShow">
                  <div class="col-2 col-form-label fw-bold ps-5">RGB</div>
                  <div class="col-10">
                    <color-picker
                      v-for="(colors, i) in colors"
                      :key="i"
                      :index="i"
                      :rgb="rgb"
                      @index="rgbFindIndex"
                      @input="changeColor"
                      @delete="deleteColor"
                    ></color-picker>
                    <button
                      type="button"
                      class="btn btn-primary mt-2"
                      @click="addColor()"
                    >
                      + 추가
                    </button>
                  </div>
                </div>
                <div class="row align-items-center mb-3">
                  <div class="col-2 col-form-label fw-bold ps-5">
                    콘텐츠 용도
                  </div>
                  <div class="col-10 position-relative">
                    <div class="form-check form-check-inline col-form-label">
                      <input
                        class="form-check-input"
                        type="radio"
                        id="useWeb"
                        value="web"
                        v-model="typeCheck"
                      />
                      <label class="form-check-label" for="useWeb">웹용</label>
                    </div>
                    <div class="form-check form-check-inline col-form-label">
                      <input
                        class="form-check-input"
                        type="radio"
                        id="usePrint"
                        value="print"
                        v-model="typeCheck"
                      />
                      <label class="form-check-label" for="usePrint"
                        >인쇄용</label
                      >
                    </div>
                  </div>
                </div>
                <div class="row mb-3" v-if="workingSizeShow">
                  <div class="col-2 col-form-label fw-bold ps-5">작업크기</div>
                  <div class="col-10">
                    <div class="row">
                      <div class="col">
                        <select
                          class="form-select me-3"
                          v-model="selectWorkingSize"
                          @change="getSize()"
                        >
                          <option
                            :value="i"
                            v-for="(sizeCategory, i) in sizeCategory"
                            :key="i"
                          >
                            {{ sizeCategory.TEMPLATE_TYPE_NAME }}
                          </option>
                        </select>
                        <select
                          class="form-select"
                          v-model="selectSize"
                          @change="getSize()"
                        >
                          <option :value="i" v-for="(size, i) in size" :key="i">
                            {{ size.SIZE_NAME }}
                          </option>
                        </select>
                      </div>
                      <div class="col">
                        <div class="row">
                          <div class="col">
                            <p>가로</p>
                            <input
                              type="text"
                              class="form-control"
                              v-model="width"
                              readonly
                            />
                          </div>
                          <div class="col">
                            <p>세로</p>
                            <input
                              type="text"
                              class="form-control"
                              v-model="height"
                              readonly
                            />
                          </div>
                          <div class="col">
                            <p>단위</p>
                            <input
                              type="text"
                              class="form-control"
                              v-model="scale"
                              readonly
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row align-items-center mb-3">
                  <div class="col-2 col-form-label fw-bold ps-5">사용여부</div>
                  <div class="col-10 position-relative">
                    <div class="form-check form-check-inline col-form-label">
                      <input
                        class="form-check-input"
                        type="radio"
                        id="publicTrue"
                        value="true"
                        v-model="publicFlage"
                      />
                      <label class="form-check-label" for="publicTrue"
                        >사용</label
                      >
                    </div>
                    <div class="form-check form-check-inline col-form-label">
                      <input
                        class="form-check-input"
                        type="radio"
                        id="publicFalse"
                        value="false"
                        v-model="publicFlage"
                      />
                      <label class="form-check-label" for="publicFalse"
                        >미사용</label
                      >
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-lg btn-primary m-auto"
                  data-bs-dismiss="modal"
                  @click="contentsListUpdate()"
                >
                  수정
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import PageName from "../components/PageName.vue";
import TableLoading from "../components/TableLoading.vue";
import table from "@/mixins.js";
import vPagination from "vue-plain-pagination";
import ColorPicker from "@/components/ColorPicker.vue";

export default {
  name: "ThemeManagement",
  components: { PageName, TableLoading, vPagination, ColorPicker },
  data() {
    return {
      main: "테마 관리",
      contents: [], // 콘텐츠 타입
      currentContents: {}, // 현재 콘텐츠 타입
      themeList: [],
      currentThemeList: {},
      selected: 0,
      listCheck: "2",
      activeContents: false,
      activeThemeList: false,
      start: 0,
      length: 10,
      indexTheme: null,
      prevSEQ_ID: null,
      nextSEQ_ID: null,
      themeName: "",
      warnning: false,
      contentsList: [],
      currentContentsList: {},
      local: "http://localhost/admin", //로컬서버
      contentsListShow: false,
      hover: true,
      useContents: [],
      unusedContents: [],
      noTheme: false,
      // 콘텐츠 추가
      contentsName: "",
      keyword: "",
      thumbnail: null,
      extension: null,
      contentsFile: null,
      sizeCategory: [],
      selectWorkingSize: 0,
      size: [],
      selectSize: 0,
      width: null,
      height: null,
      scale: null,
      typeCheck: "web",
      publicFlage: "true",
      thumbPath: null,
      contentsPath: null,
      contentsFileName: null,
      invalidContentsName: false,
      invalidKeyword: false,
      invalidThumbnail: false,
      invalidContents: false,
      oldThumb: [],
      oldContents: [],
      existsThumb: false,
      existsContents: false,
      editContents: false,
      contentsUpdatePath: null,
      workingSizeShow: false,
      rgbShow: false,
      colors: [],
      rgb: [],
      rgbIndex: 0,
    };
  },
  mixins: [table],
  computed: {},
  methods: {
    getContentsType() {
      this.$axios.get("/admin/api/theme.php").then((response) => {
        this.contents = response.data;
        this.$endloading();
      });
    },
    selectContentsType(i, contents) {
      this.warnning = false;
      if (this.listCheck == "1") {
        const contentsType = contents.CONTENTS_TYPE_NAME;
        const warnning =
          contentsType == "템플릿" ||
          contentsType == "텍스트" ||
          contentsType == "도형" ||
          contentsType == "표" ||
          contentsType == "차트" ||
          contentsType == "스타일" ||
          contentsType == "폰트";
        if (warnning) return (this.warnning = true);
      }
      this.activeContents = i;
      this.selected = i + 1;
      this.currentContents = contents;
      this.activeThemeList = false;
      this.contentsListShow = false;
      this.getTheme();
    },
    hoverType(value) {
      if (this.listCheck == "1") {
        const hover =
          value == "사진" ||
          value == "일러스트" ||
          value == "3D" ||
          value == "아이콘" ||
          value == "논텍스트" ||
          value == "배경" ||
          value == "동영상" ||
          value == "모션그래픽" ||
          value == "GIF" ||
          value == "사운드";
        if (hover) {
          this.hover = true;
        } else {
          this.hover = false;
        }
      } else {
        this.hover = true;
      }
    },
    selectOption(i) {
      if (
        (this.listCheck == "1" && i == 1) ||
        (this.listCheck == "1" && i == 12) ||
        (this.listCheck == "1" && i == 13) ||
        (this.listCheck == "1" && i == 14) ||
        (this.listCheck == "1" && i == 15) ||
        (this.listCheck == "1" && i == 16) ||
        (this.listCheck == "1" && i == 17)
      ) {
        return (this.warnning = true);
      } else {
        this.warnning = false;
      }
      this.currentContents = this.contents[i - 1];
      this.activeContents = i - 1;
      this.activeThemeList = false;
      this.contentsListShow = false;
      this.getTheme();
    },
    getTheme() {
      if (this.currentContents.CONTENTS_TYPE_NAME == "스타일")
        this.rgbShow = true;
      else this.rgbShow = false;
      if (this.listCheck == "2") {
        this.$loading();
        this.$axios
          .get("/admin/api/theme.php", {
            params: {
              contents: this.currentContents.SEQ_ID,
              start: this.start,
              length: this.length,
            },
          })
          .then((response) => {
            if (response.data.length == 0) this.noTheme = true;
            else this.noTheme = false;
            this.themeList = response.data;
            this.totalPage();
            this.$endloading();
          });
      } else if (this.listCheck == "1") {
        this.themeList = [];
      }
    },
    selectThemeList(i, themeList) {
      this.activeThemeList = i;
      this.currentThemeList = themeList;
    },
    totalPage() {
      if (this.listCheck == "2") {
        this.$axios
          .get("/admin/api/theme-page.php", {
            params: { contents: this.currentContents.SEQ_ID },
          })
          .then((response) => {
            this.totalPages = response.data;
            this.totalPages = Math.ceil(this.totalPages / this.length);
          });
      }
    },
    getCurrentPage() {
      if (this.listCheck == "2") {
        this.$loading();
        let i = this.currentPage;
        let page = this.length;
        i = page * i - page;
        this.start = i;
        this.$axios
          .get("/admin/api/theme.php", {
            params: {
              contents: this.currentContents.SEQ_ID,
              start: this.start,
              length: this.length,
            },
          })
          .then((response) => {
            this.themeList = response.data;
            this.$endloading();
          });
      }
    },
    upCurrentTheme(i) {
      if (this.themeList[i].ORDER == 0) return;
      this.currentThemeList = this.themeList[i].SEQ_ID;
      if (i !== 0) {
        this.prevSEQ_ID = this.themeList[i - 1].SEQ_ID;
        this.indexTheme = this.themeList[i].ORDER - 1;
        this.orderThemePrev();
      } else if (i === 0) {
        //2페이지 이상
        this.indexTheme = this.start - 1;
        let i = this.currentPage;
        let page = this.length;
        i = page * i - page;
        this.start = i;
        this.$axios
          .get("/admin/api/theme.php", {
            params: {
              contents: this.currentContents.SEQ_ID,
              start: this.start - 1,
              length: 1,
            },
          })
          .then((response) => {
            this.prevSEQ_ID = response.data[0].SEQ_ID;
            this.orderThemePrev();
          });
      }
    },
    downCurrentTheme(i) {
      this.currentThemeList = this.themeList[i].SEQ_ID;
      if (i <= 8) {
        this.nextSEQ_ID = this.themeList[i + 1].SEQ_ID;
        this.indexTheme = parseInt(this.themeList[i].ORDER) + 1;
        this.orderThemeNext();
      } else if (i === 9) {
        this.indexTheme = this.start + this.length;
        let i = this.currentPage;
        let page = this.length;
        i = page * i - page;
        this.start = i;
        this.$axios
          .get("/admin/api/theme.php", {
            params: {
              contents: this.currentContents.SEQ_ID,
              start: this.start + this.length,
              length: 1,
            },
          })
          .then((response) => {
            this.nextSEQ_ID = response.data[0].SEQ_ID;
            this.orderThemeNext();
          });
      }
    },
    orderTheme() {
      if (this.indexTheme === null) return;
      this.$loading();
      const fd = new FormData();
      fd.append("ORDER", this.indexTheme);
      fd.append("SEQ_ID", this.currentThemeList);
      this.$axios.post("/admin/api/theme-order.php", fd).then((response) => {
        if (response.data.DB !== "success")
          return alert("API Error: " + response.data);
        this.getTheme();
      });
    },
    orderThemeNext() {
      this.$loading();
      const fd = new FormData();
      fd.append("ORDER", this.indexTheme - 1);
      fd.append("NEXT", this.nextSEQ_ID);
      this.$axios.post("/admin/api/theme-order.php", fd).then((response) => {
        if (response.data.DB !== "success")
          return alert("API Error: " + response.data);
      });
    },
    orderThemePrev() {
      this.$loading();
      const fd = new FormData();
      fd.append("ORDER", this.indexTheme + 1);
      fd.append("PREV", this.prevSEQ_ID);
      this.$axios.post("/admin/api/theme-order.php", fd).then((response) => {
        if (response.data.DB !== "success")
          return alert("API Error: " + response.data);
      });
    },
    addTheme() {
      if ((this.activeContents !== false) & (this.themeName !== "")) {
        const fd = new FormData();
        fd.append("CONTENTS_CATEGORY_ID", this.currentContents.SEQ_ID);
        fd.append("THEME_NAME", this.themeName);
        if (this.totalPages > 2) {
          fd.append("ORDER", this.themeList.length);
        } else {
          let lastOrder = (this.totalPages - 1) * 10;
          if (lastOrder < 0) lastOrder = 0;
          fd.append("ORDER", this.themeList.length + lastOrder);
        }
        this.$loading();
        this.$axios.post("/admin/api/theme-insert.php", fd).then((response) => {
          if (response.data.DB !== "success")
            return alert("API Error: " + response.data);
          this.getTheme();
        });
      }
    },
    deleteTheme(id) {
      const fd = new FormData();
      fd.append("deleteTheme", id);
      fd.append("THEME_ID", id);
      if (window.confirm("정말 삭제하시겠습니까?")) {
        this.$loading();
        this.$axios.post("/admin/api/theme-delete.php", fd).then((response) => {
          if (response.data.DB !== "success")
            return alert("API Error: " + response.data);
          this.getTheme();
        });
      }
    },
    getContentsList() {
      this.contentsListShow = true;
      this.$loading();
      this.$axios
        .get("/admin/api/theme-contents.php", {
          params: {
            id: this.currentThemeList.SEQ_ID,
          },
        })
        .then((response) => {
          this.contentsList = response.data;
          this.$endloading();
          this.useContents = [];
          this.unusedContents = [];
          for (const i in this.contentsList) {
            // 사용 컨텐츠 보여줌
            if (this.contentsList[i].PUBLIC_FLAG == 1) {
              this.useContents.push(this.contentsList[i].SEQ_ID);
            }
          }
        });
    },
    contentsListCheck(event) {
      let value = event.target.value;
      if (event.target.checked === false) {
        this.unusedContents.push(value);
        let set = new Set(this.unusedContents);
        this.unusedContents = [...set];
        const index = this.useContents.indexOf(value);
        if (index > -1) this.useContents.splice(index, 1);
      } else if (event.target.checked === true) {
        this.useContents.push(value);
        let set = new Set(this.useContents);
        this.useContents = [...set];
        const index = this.unusedContents.indexOf(value);
        if (index > -1) this.unusedContents.splice(index, 1);
      }
    },
    contentsUseUnused() {
      // 사용
      if (this.useContents !== []) {
        for (const i in this.useContents) {
          const fd = new FormData();
          fd.append("PUBLIC_FLAG", 1);
          fd.append("contentsUseUnused", this.useContents[i]);
          this.$axios
            .post("/admin/api/theme-update.php", fd)
            .then((response) => {
              if (response.data.DB !== "success")
                return alert("API Error: " + response.data);
            });
        }
      }
      // 미사용
      if (this.unusedContents !== []) {
        for (const i in this.unusedContents) {
          const fd = new FormData();
          fd.append("PUBLIC_FLAG", 0);
          fd.append("contentsUseUnused", this.unusedContents[i]);
          this.$axios
            .post("/admin/api/theme-update.php", fd)
            .then((response) => {
              if (response.data.DB !== "success")
                return alert("API Error: " + response.data);
            });
        }
      }
      if (this.unusedContents !== [] || this.useContents !== [])
        alert("사용여부 변경됨");
    },
    deleteContents(contents) {
      this.contentsPathFormat();
      const fd = new FormData();
      fd.append("deleteContents", contents.SEQ_ID);
      fd.append("contentsPath", this.contentsPath);
      if (window.confirm("정말 삭제하시겠습니까?")) {
        this.$loading();
        this.$axios.post("/admin/api/theme-delete.php", fd).then((response) => {
          if (response.data.DB !== "success")
            return alert("API Error: " + response.data);
          this.getContentsList();
        });
      }
    },
    getSizeCategory() {
      if (this.currentContents.CONTENTS_TYPE_NAME == "템플릿") {
        this.workingSizeShow = true;
        this.$axios.get("/admin/api/theme-size.php").then((response) => {
          this.sizeCategory = response.data;
          this.getSize();
          this.$endloading();
        });
      } else {
        this.workingSizeShow = false;
      }
    },
    getSize() {
      this.$loading();
      this.$axios
        .get("/admin/api/theme-size.php", {
          params: {
            template: this.sizeCategory[this.selectWorkingSize].SEQ_ID,
          },
        })
        .then((response) => {
          this.size = response.data;
          this.selectSize = 0;
          this.activeSizeName();
          this.$endloading();
        });
    },
    activeSizeName() {
      if (this.size.length === 0 || this.size === null) return;
      console.log(this.size);
      console.log(this.selectSize);
      this.$loading();
      this.$axios
        .get("/admin/api/theme-size.php", {
          params: {
            size: this.size[this.selectSize].SEQ_ID,
          },
        })
        .then((response) => {
          this.width = response.data[0].PAGE_WIDTH;
          this.height = response.data[0].PAGE_HEIGHT;
          this.scale = response.data[0].SCALE_CD;
          this.scaleFormat(this.scale);

          this.$endloading();
        });
    },
    scaleFormat(value) {
      if (value == 1) return (this.scale = "px");
      if (value == 2) return (this.scale = "mm");
      if (value == 3) return (this.scale = "cm");
      if (value == 4) return (this.scale = "inch");
    },
    contentsPathFormat() {
      const contentsType = this.currentContents.CONTENTS_TYPE_NAME;
      if (contentsType == "템플릿")
        return (this.contentsPath = "./contents/template/");
      if (contentsType == "텍스트")
        return (this.contentsPath = "./contents/text/");
      if (contentsType == "도형")
        return (this.contentsPath = "./contents/shape/");
      if (contentsType == "표")
        return (this.contentsPath = "./contents/table/");
      if (contentsType == "차트")
        return (this.contentsPath = "./contents/chart/");
      if (contentsType == "스타일")
        return (this.contentsPath = "./contents/style/");
    },
    thumbPathFormat(id) {
      this.contentsPathFormat();
      if (id != undefined) {
        this.thumbPath = `${id}_${this.time()}`;
        this.thumbPath = `${this.contentsPath}thumb/${this.thumbPath}.`;
        if (this.rgbShow === true) this.contentsFileName = `${id}_STYLE.json`;
        return;
      }
      this.$axios.get("/admin/api/theme-file-name.php").then((response) => {
        this.thumbPath = `${response.data[0].AUTO_INCREMENT}_${this.time()}`;
        this.thumbPath = `${this.contentsPath}thumb/${this.thumbPath}.`;
        if (this.rgbShow === true)
          this.contentsFileName = `${response.data[0].AUTO_INCREMENT}_STYLE.json`;
      });
    },
    thumbFileSelect(event) {
      const input = event.target;
      if (input.files && input.files[0]) {
        this.existsThumb = true;
        const reader = new FileReader();
        reader.onload = (e) => {
          this.thumbnail = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
        this.extension = input.files[0].name;
        this.extension = this.extension.split(".", 2)[1];
        this.thumbPath = this.thumbPath + this.extension;
      }
    },
    contentsFileSelect(event) {
      const input = event.target;
      if (input.files && input.files[0]) {
        this.existsContents = true;
        const reader = new FileReader();
        reader.onload = (e) => {
          this.contentsFile = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
        this.contentsFileName = input.files[0].name;
        this.$axios.get("/admin/api/theme-file-name.php").then((response) => {
          this.contentsFileName = `${response.data[0].AUTO_INCREMENT}_${this.contentsFileName}`;
        });
      }
    },
    thumbnailUpload() {
      const fd = new FormData();
      fd.append("base64", this.thumbnail);
      fd.append("thumbnail", this.thumbPath);
      this.$axios
        .post("/admin/api/theme-file-upload.php", fd)
        .then((response) => {
          if (response.data == "error") {
            return alert("썸네일 저장 실패 :" + response.data);
          }
        });
    },
    contentsFileUpload() {
      const fd = new FormData();
      fd.append("base64", this.contentsFile);
      fd.append("contents", this.contentsPath + this.contentsFileName);
      this.$axios
        .post("/admin/api/theme-file-upload.php", fd)
        .then((response) => {
          if (response.data == "error") {
            return alert("콘텐츠 파일 저장 실패 :" + response.data);
          }
        });
    },
    validation() {
      if (this.contentsName === "") return (this.invalidContentsName = true);
      if (this.keyword === "") return (this.invalidKeyword = true);
      if (this.thumbnail === null) return (this.invalidThumbnail = true);
      if (this.contentsFile === null && this.rgbShow === false)
        return (this.invalidContents = true);
    },
    contentsUpload() {
      if (this.validation()) return;
      this.$loading();
      const fd = new FormData();
      fd.append("CONTENTS_NAME", this.contentsName);
      fd.append("THEME_ID", this.currentThemeList.SEQ_ID);
      fd.append("KEYWORD", this.keyword);
      fd.append("THUMB_PATH", this.thumbPath);
      fd.append("CONTENTS_PATH", this.contentsPath + this.contentsFileName);
      if (this.typeCheck === "web") {
        fd.append("USE_TYPE", 1);
      } else if (this.typeCheck === "print") {
        fd.append("USE_TYPE", 2);
      }
      if (this.currentContents.CONTENTS_TYPE_NAME == "템플릿") {
        fd.append(
          "SIZE_CATEGORY_ID",
          this.sizeCategory[this.selectWorkingSize].SEQ_ID
        );
        fd.append("SIZE_INFO_ID", this.size[this.selectSize].SEQ_ID);
      } else {
        fd.append("SIZE_CATEGORY_ID", null);
        fd.append("SIZE_INFO_ID", null);
      }
      if (this.publicFlage === "true") {
        fd.append("PUBLIC_FLAG", 1);
      } else if (this.publicFlage === "false") {
        fd.append("PUBLIC_FLAG", 0);
      }
      fd.append("A_ID", 0);
      fd.append("U_ID", 0);
      const img = document.querySelector("#thumbFile");
      const json = document.querySelector("#contentsFile");
      this.$axios.post("/admin/api/theme-insert.php", fd).then((response) => {
        if (response.data == "error") {
          return alert("콘텐츠 파일 저장 실패 :" + response.data);
        }
        this.thumbnailUpload();
        if (this.rgbShow === false) this.contentsFileUpload();
        if (this.rgbShow === true) this.rgbJsonUpload();
        this.contentsName = "";
        this.keyword = "";
        this.thumbnail = null;
        this.contentsFile = null;
        img.value = "";
        if (this.rgbShow === false) json.value = "";
        this.ColorPicker = [];
        this.rgb = [];
        this.getContentsList();
        this.thumbPathFormat();
        alert("업로드 성공");
      });
    },
    selectContentsList(contents) {
      this.editContents = true;
      this.existsThumb = false;
      this.existsContents = false;
      const img = document.querySelector("#thumbFileEdit");
      const json = document.querySelector("#contentsFileEdit");
      img.value = "";
      if (this.rgbShow === false) json.value = "";
      // 선택 콘텐츠 정보
      this.$loading();
      this.currentContentsList = contents;
      this.contentsName = contents.CONTENTS_NAME;
      this.keyword = contents.KEYWORD;
      this.thumbnail = contents.THUMB_PATH;
      this.thumbnail = this.local + contents.THUMB_PATH.substring(1); // 로컬서버
      if (contents.USE_TYPE == 1) {
        this.typeCheck = "web";
      } else if (contents.USE_TYPE == 2) this.typeCheck = "print";
      this.publicFlage = contents.PUBLIC_FLAG;
      if (contents.PUBLIC_FLAG == 1) {
        this.publicFlage = "true";
      } else if (contents.PUBLIC_FLAG == 0) this.publicFlage = "false";
      if (this.rgbShow === true) {
        this.colors = [];
        this.rgb = [];
        this.contentsPathFormat();
        const fd = new FormData();
        fd.append("CONTENTS_PATH", this.currentContentsList.CONTENTS_PATH);
        this.$axios
          .post("/admin/api/theme-contents.php", fd)
          .then((response) => {
            const json = response.data;
            json.forEach((value) => {
              this.colors.push(ColorPicker);
              this.rgb.push(value);
            });
          });
      }
    },
    oldThumbFile(contents) {
      this.$loading();
      let currentImg = contents.THUMB_PATH.split("/");
      currentImg = currentImg[currentImg.length - 1];
      this.contentsPathFormat();
      const fd = new FormData();
      fd.append("thumbDir", this.contentsPath + "thumb");
      fd.append("currentImg", currentImg);
      fd.append("SEQ_ID", contents.SEQ_ID);
      this.$axios.post("/admin/api/theme-old-file.php", fd).then((response) => {
        this.$endloading();
        if (response.data.length == 0) {
          return (this.oldThumb = []);
        } else {
          this.oldThumb = [];
          response.data.forEach((data) => {
            let oldFile = `${this.contentsPath}thumb/${data}`;
            oldFile = `${this.local}${oldFile.substring(1)}`; // 로컬서버
            this.oldThumb.push(oldFile);
          });
        }
      });
    },
    oldContentsFile(contents) {
      this.$loading();
      this.contentsPathFormat();
      let currentContents = contents.CONTENTS_PATH.split("/");
      currentContents = currentContents[currentContents.length - 1];
      const fd = new FormData();
      fd.append("contentsDir", this.contentsPath);
      fd.append("currentContents", currentContents);
      fd.append("SEQ_ID", contents.SEQ_ID);
      this.$axios.post("/admin/api/theme-old-file.php", fd).then((response) => {
        this.$endloading();
        if (response.data.length == 0) {
          return (this.oldContents = []);
        } else {
          this.oldContents = response.data;
        }
      });
    },
    deleteOldThumb(value) {
      if (window.confirm("완전히 삭제하시겠습니까?")) {
        value = "." + value;
        value = value.split("admin"); // 로컬서버
        value = ".." + value[1]; // 로컬서버
        const fd = new FormData();
        fd.append("deleteOldThumb", value);
        this.$axios
          .post("/admin/api/theme-old-file.php", fd)
          .then((response) => {
            if (response.data !== "success")
              return alert("API Error :" + response.data);
            this.selectContentsList(this.currentContentsList);
            this.oldThumbFile(this.currentContentsList);
          });
      }
    },
    deleteOldContents(value) {
      if (window.confirm("완전히 삭제하시겠습니까?")) {
        value = `.${this.contentsPath}${value}`;
        const fd = new FormData();
        fd.append("deleteOldContents", value);
        this.$axios
          .post("/admin/api/theme-old-file.php", fd)
          .then((response) => {
            if (response.data !== "success")
              return alert("API Error :" + response.data);
            this.selectContentsList(this.currentContentsList);
            this.oldContentsFile(this.currentContentsList);
          });
      }
    },
    changeThumb(value) {
      if (window.confirm("썸네일을 변경합니다.")) {
        value = "." + value;
        value = value.split("admin"); // 로컬서버
        value = "." + value[1]; // 로컬서버
        const fd = new FormData();
        fd.append("changeThumb", value);
        fd.append("SEQ_ID", this.currentContentsList.SEQ_ID);
        this.$axios
          .post("/admin/api/theme-old-file.php", fd)
          .then((response) => {
            if (response.data.DB !== "success")
              return alert("API Error: " + response.data);
            this.getContentsList();
            value = this.local + value.substring(1); // 로컬서버
            this.thumbnail = value;
          });
      }
    },
    changeContents(value) {
      if (window.confirm("콘텐츠를 변경합니다.")) {
        const fd = new FormData();
        value = `.${this.contentsPath}${value}`;
        fd.append("changeContents", value);
        fd.append("SEQ_ID", this.currentContentsList.SEQ_ID);
        this.$axios
          .post("/admin/api/theme-old-file.php", fd)
          .then((response) => {
            if (response.data.DB !== "success")
              return alert("API Error: " + response.data);
            this.getContentsList();
          });
      }
    },
    contentsListUpdate() {
      if (this.contentsName === "") return (this.invalidContentsName = true);
      if (this.keyword === "") return (this.invalidKeyword = true);
      const fd = new FormData();
      fd.append("contentsListUpdate", this.currentContentsList.SEQ_ID);
      fd.append("CONTENTS_NAME", this.contentsName);
      fd.append("KEYWORD", this.keyword);
      if (this.existsThumb === true) {
        fd.append("THUMB_PATH", this.thumbPath);
        console.log("첨부" + this.thumbPath);
      } else if (this.existsThumb === false) {
        fd.append("THUMB_PATH", this.currentContentsList.THUMB_PATH);
        console.log("파일없음" + this.currentContentsList.THUMB_PATH);
      }
      fd.append("CONTENTS_PATH", this.contentsUpdatePath);
      if (this.rgbShow === true)
        fd.append("CONTENTS_PATH", this.currentContentsList.CONTENTS_PATH);
      if (this.typeCheck === "web") fd.append("USE_TYPE", 1);
      else if (this.typeCheck === "print") fd.append("USE_TYPE", 2);
      if (this.currentContents.CONTENTS_TYPE_NAME == "템플릿") {
        fd.append(
          "SIZE_CATEGORY_ID",
          this.sizeCategory[this.selectWorkingSize].SEQ_ID
        );
        fd.append("SIZE_INFO_ID", this.size[this.selectSize].SEQ_ID);
      } else {
        fd.append("SIZE_CATEGORY_ID", null);
        fd.append("SIZE_INFO_ID", null);
      }
      if (this.publicFlage === "true") {
        fd.append("PUBLIC_FLAG", 1);
      } else if (this.publicFlage === "false") {
        fd.append("PUBLIC_FLAG", 0);
      }
      if (this.existsContents === true) {
        const json = document.querySelector("#contentsFileEdit");
        this.contentsFileName = this.contentsFileName.split("_")[1];
        this.contentsFileName = `${this.currentContentsList.SEQ_ID}_${json.files[0].name}`;
        fd.append("CONTENTS_PATH", this.contentsPath + this.contentsFileName);
      }
      this.$axios.post("/admin/api/theme-update.php", fd).then((response) => {
        if (response.data.DB !== "success")
          return alert("API Error: " + response.data);
        if (this.existsThumb === true) this.thumbnailUpload();
        if (this.existsContents === true && this.rgbShow === false)
          this.contentsFileUpload();
        if (this.rgbShow === true) this.rgbJsonUpload();
        this.getContentsList();
        alert("수정 완료");
      });
    },
    contentsFileFormat(value) {
      if (value !== undefined) {
        let file = value.split("/");
        file = file[file.length - 1];
        this.contentsUpdatePath = this.contentsPath + file;
        return file;
      }
    },
    time() {
      const today = new Date();
      const year = today.getFullYear();
      const month = ("0" + (today.getMonth() + 1)).slice(-2);
      const day = ("0" + today.getDate()).slice(-2);
      const hours = ("0" + today.getHours()).slice(-2);
      const minutes = ("0" + today.getMinutes()).slice(-2);
      const seconds = ("0" + today.getSeconds()).slice(-2);
      const time = `${year}${month}${day}${hours}${minutes}${seconds}`;
      return time;
    },
    addColor() {
      this.colors.push(ColorPicker);
      this.rgb.push("#000000");
    },
    deleteColor(i) {
      this.colors.splice(i, 1);
      this.rgb.splice(i, 1);
    },
    rgbFindIndex(i) {
      this.rgbIndex = i;
    },
    changeColor(value) {
      this.rgb[this.rgbIndex] = value;
    },
    rgbJsonUpload() {
      const fd = new FormData();
      fd.append(`length`, this.rgb.length);
      for (const i in this.rgb) {
        fd.append(`rgb${i}`, this.rgb[i]);
      }
      fd.append("saveDir", this.contentsPath + this.contentsFileName);
      this.$axios
        .post("/admin/api/theme-file-upload.php", fd)
        .then((response) => {
          if (response.data == "error") {
            return alert("콘텐츠 파일 저장 실패 :" + response.data);
          }
        });
    },
    themeKeyupEvent() {
      if (window.event.key == "ArrowUp") {
        if (this.activeThemeList > 0) {
          let i = this.activeThemeList;
          this.currentThemeList = this.themeList[i].SEQ_ID;
          this.prevSEQ_ID = this.themeList[i - 1].SEQ_ID;
          i = i - 1;
          if (i == -1) i = 0;
          this.indexTheme = i + this.start;
          this.orderThemePrev();
          this.orderTheme();
          this.activeThemeList = this.activeThemeList - 1;
        } else if (this.activeThemeList == 0) {
          return;
        }
      } else if (window.event.key == "ArrowDown") {
        if (this.themeList.length > this.activeThemeList + 1) {
          let i = this.activeThemeList;
          this.currentThemeList = this.themeList[i].SEQ_ID;
          if (this.themeList.length - 1 == i) {
            this.nextSEQ_ID = this.themeList[i].SEQ_ID;
          } else {
            this.nextSEQ_ID = this.themeList[i + 1].SEQ_ID;
          }
          i = i + 1;
          if (this.themeList.length == i) {
            i = i - 1;
          }
          this.indexTheme = i + this.start;
          this.orderThemeNext();
          this.orderTheme();
          this.activeThemeList = this.activeThemeList + 1;
        } else if (this.themeList.length == this.activeThemeList + 1) {
          return;
        }
      }
    },
  },
  mounted() {
    this.getContentsType();
    window.addEventListener("keyup", () => {
      if (this.tableLoading === false) {
        this.themeKeyupEvent();
      }
    });
  },
};
</script>

<style scoped>
.pagination {
  justify-content: center !important;
}
#top {
  height: 50vh;
}
.overflow-auto {
  max-height: 40vh;
}
#bottom {
  height: 35vh;
}
#theme {
  height: calc(40vh + 42px);
}
.alert {
  animation: 0.3s warnning;
}
@keyframes warnning {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
  }
}
.modal-dialog {
  max-width: 1000px !important;
}
.modal-content {
  width: 100% !important;
}
.form-select {
  margin: 0;
}
.thumbnail {
  width: 100px;
  height: 100px;
}
.hover:hover {
  cursor: pointer;
  background-color: var(--bs-blue);
  color: var(--bs-white);
}
.icon-size {
  font-size: 3rem;
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}
#oldThumb {
  max-height: 175px;
  overflow: auto;
}
#oldContents {
  max-height: 125px;
  overflow: auto;
}
.oldIcon {
  height: 60px;
}
</style>
