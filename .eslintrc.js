module.exports = {
  env: {
    browser: true,
    es2021: true,
  },
  extends: [
    'eslint:recommended',
    'plugin:vue/vue3-essential',
    'plugin:vuejs-accessibility/recommended',
  ],
  ignorePatterns: ['ziggy', '**/*.ts'],
  overrides: [
    {
      env: {
        node: true,
      },
      files: ['.eslintrc.{js,cjs}'],
      parserOptions: {
        sourceType: 'script',
      },
    },
  ],
  plugins: ['vue', 'vuejs-accessibility'],
  rules: {
    'vue/multi-word-component-names': 0, // 關閉檔名必須要用駝峰命名
    'vue/no-reserved-component-names': 0, // 關閉組件保留名稱限制
    'vue/no-multiple-template-root': 0, // 關閉template只能單一節點限制
    'vue/no-v-model-argument': 0, // 關閉v-model後綴語法限制
    'no-undef': 0, // 允許變數值為undefined
    'vuejs-accessibility/no-autofocus': 0, // 關閉禁止使用autofocus
    'vuejs-accessibility/no-onchange': 0, // 關閉必須使用@blur事件
    'vuejs-accessibility/no-access-key': 0, // 關閉禁止使用accesskey屬性
    'vuejs-accessibility/label-has-for': 0, // 關閉label標籤必需加for屬性
    'vuejs-accessibility/heading-has-content': 0, // 關閉h1標籤內必須要有文字
    'vuejs-accessibility/form-control-has-label': 0, // 關閉Form內必須有label
    'vuejs-accessibility/no-static-element-interactions': 0, // 關閉強制使用交互性元素
    'no-console': 1, // 提醒仍有console.log未移除
    'eol-last': 2, // 最後一行必須有換行符號
    eqeqeq: 2, // 強制使用 === 取代 ==
    'no-var': 2, // 禁止使用var變數
    'linebreak-style': 2, // 強制使用LF換行符
    'no-multiple-empty-lines': [2, { max: 1 }], // 空行最多不能超過1行
    'no-trailing-spaces': 2, // 禁止行尾空格
    'no-multi-spaces': 2, // 禁止js有多餘的空格
    'vue/no-multi-spaces': 2, // 禁止html有多餘的空格
    'vue/no-spaces-around-equal-signs-in-attribute': 2, // 禁止html屬性的等號前後有空格
    'vue/attribute-hyphenation': 2, // 強制自定義組件上屬性使用kebab-case命名風格
    'vue/v-on-event-hyphenation': 2, // 強制自定義組件上自定義事件使用kebab-case命名風格
    'vue/component-name-in-template-casing': 2, // 強制自定義組件在模板使用大駝峰風格
    'vue/html-closing-bracket-spacing': 2, // 強制html標籤閉合前一致性空格
    'vue/mustache-interpolation-spacing': 2, // 強制html插值語法大括號前後必須有空格
    'vue/require-explicit-emits': 2, // 如果有emit則強制要寫emits實例
    'vue/order-in-components': 2, // 組件中的實例保持推薦的順序
    'vue/html-button-has-type': 2, // 強制button標籤必須加上type屬性
    'vue/no-useless-v-bind': 2, // 禁止不必要的v-bind指令
    'vue/no-static-inline-styles': 2, // 靜止靜態的style樣式
    'vue/custom-event-name-casing': 2, // 自定義事件名稱強制使用小駝峰
    'vue/this-in-template': 2, // html模板中禁止使用this
    'vue/padding-line-between-blocks': 2, // 要求vue區塊間需要有空行
    'vue/no-useless-mustaches': 2, // 禁止非必要的{{}}使用
    'vue/dot-notation': 2, // 強制在template物件非變數則使用點去取值
    'vue/eqeqeq': 2, // 強制在template使用 === 取代 ==
    'vue/key-spacing': 2, // 強迫template物件的鍵值中間一致的空格
    'vue/array-bracket-spacing': 2, // 強制template中括號内一致的空格
    'vue/arrow-spacing': 2, // 強制template箭頭函式的箭頭前後需有空格
    'vue/comma-spacing': 2, // 強制template逗號使用的一致格式
    'vue/object-curly-spacing': [2, 'always'], // 強制template統一物件的前後空格格式
    'vue/space-in-parens': 2, // 禁止template圓括號前後閉合多餘空格
    'vue/space-infix-ops': 2, // 要求template運算子的前後空格一致
    'vue/prop-name-casing': 2, // 強制Prop名稱使用小駝峰
    'vue/html-comment-content-spacing': 2, // 強制在HTML註解中統一間距
    'vue/prefer-true-attribute-shorthand': 2, // 強制當傳的Props是布林值時使用簡寫
    'vue/html-indent': [
      2,
      2,
      {
        attribute: 1,
        baseIndent: 1,
        closeBracket: 0,
        alignAttributesVertically: false,
      },
    ], // html的縮排
    indent: [2, 2], // 縮排統一為2格
    'no-nested-ternary': 2, // 禁止多嵌套的三元表達式
    'no-else-return': 2, // 禁止if判斷式return之後有else
    quotes: [2, 'single'], // 強制使用單引號
    semi: 2, // 強制加句尾分號
    'array-bracket-spacing': 2, // 強制中括號内一致的空格
    'comma-spacing': 2, // 強制逗號使用的一致格式
    'key-spacing': 2, // 強迫物件的鍵值中間一致的空格
    'space-in-parens': 2, // 禁止圓括號前後閉合多餘空格
    'spaced-comment': 2, // 要求一致的註釋格式
    'arrow-spacing': 2, // 箭頭函式的箭頭前後需有空格
    'space-infix-ops': 2, // 要求運算子的前後空格一致
    'keyword-spacing': 2, // 強制關鍵字(function、if...)空格的一致性
    'no-whitespace-before-property': 2, // 禁止屬性前有空白
    'space-before-blocks': 2, // 強制區域塊之前一致性的空格
    'dot-notation': 2, // 強制物件非變數則使用點去取值
    'object-curly-spacing': [2, 'always'], // 強制統一物件的前後空格格式
    'comma-dangle': [2, 'always-multiline'], // 強制物件及陣列多行時的句尾逗號
    'space-before-function-paren': [
      2,
      { anonymous: 'always', named: 'never' },
    ], // 強制函式圓括號之前空格一致性
  },
};
