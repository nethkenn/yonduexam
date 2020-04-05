import LoadingMixin            from '../mixins/loading_mixin'
import NotifyMixin             from '../mixins/notify_mixin'


export default ({ Vue }) => {
  Vue.mixin(LoadingMixin);
  Vue.mixin(NotifyMixin);
}
