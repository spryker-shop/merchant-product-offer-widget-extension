import './style.scss';
import register from 'ShopUi/app/registry';
export default register('comment-thread-list', () => import(/* webpackMode: "lazy" */'./comment-thread-list'));
